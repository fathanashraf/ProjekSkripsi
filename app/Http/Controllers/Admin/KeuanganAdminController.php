<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use App\Models\Acara;
use App\Models\Biaya;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KeuanganAdminController extends Controller
{
    /**
     * Display the keuangan dashboard.
     */
    public function index()
    {
        $totalPembayaran = Keuangan::count();
        $totalPeserta = Pembayaran::count();
        $totalAcara = Acara::count();

        // Fix: count distinct payment methods instead of all payments
        $totalMetode = Pembayaran::select('jenis')->distinct()->count();

        $totalMidtrans = Pembayaran::where('jenis', 'midtrans')->count();
        $totalManual = Pembayaran::whereIn('jenis', ['cash', 'kredit'])->count();

        $keuangan = Keuangan::with(['pembayaran.acara.user', 'pendaftaran', 'user', 'acara', 'biaya'])
            ->latest()
            ->get();

        $pembayarans = $keuangan->map(function ($keuangan) {
            return [
                'keuangan' => $keuangan,
                'pembayaran' => $keuangan->pembayaran,
            ];
        });

        return view('admin.keuangan.index', compact(
            'totalPembayaran',
            'totalPeserta',
            'totalAcara',
            'totalMetode',
            'totalMidtrans',
            'totalManual',
            'pembayarans',
            'keuangan',
        ));
    }

    /**
     * Show the form for creating a new keuangan record.
     */
    public function create()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();
        $acaras = Acara::select('id', 'name_acara')->orderBy('name_acara')->get();
        $biayas = Biaya::select('id', 'name_biaya', 'nominal')->orderBy('name_biaya')->get();
        $pendaftarans = Pendaftaran::select('id', 'nama_pendaftar')->latest()->get();

        return response()->json([
            'users' => $users,
            'acaras' => $acaras,
            'biayas' => $biayas,
            'pendaftarans' => $pendaftarans,
        ]);
    }

    /**
     * Store a newly created keuangan/pembayaran record.
     */
    public function store(Request $request)
    {
        // Bersihkan titik (thousands separator Indonesia) dari nominal
        $request->merge([
            'nominal' => str_replace('.', '', $request->nominal),
        ]);

        // Fix: use $request->validate() instead of invalid $request->validated()
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'acara_id' => 'required|exists:acaras,id',
            'pendaftaran_id' => 'nullable|exists:pendaftarans,id',
            'biaya_id' => 'nullable|exists:biayas,id',
            'jenis' => 'required|string|in:pemasukan,pengeluaran',
            'kategori' => 'nullable|string|max:255',
            'nominal' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:1000',
        
            // Pembayaran fields
            'status' => 'nullable|string|in:dibayar,belum_dibayar,menunggu,lunas',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $path = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            // Create pembayaran record
            $pembayaran = Pembayaran::create([
                'user_id' => $validated['user_id'] ?? auth()->id(),
                'acara_id' => $validated['acara_id'],
                'pendaftaran_id' => $validated['pendaftaran_id'] ?? null,
                'jenis' => $validated['jenis'] === 'pemasukan' ? 'cash' : 'kredit',
                'status' => $validated['status'] ?? 'dibayar',
                'bukti_pembayaran' => $path,
            ]);

            // Create keuangan record
            Keuangan::create([
                'user_id' => $validated['user_id'] ?? auth()->id(),
                'acara_id' => $validated['acara_id'],
                'pendaftaran_id' => $validated['pendaftaran_id'] ?? null,
                'pembayaran_id' => $pembayaran->id,
                'pembayarans_id' => $pembayaran->id,
                'biaya_id' => $validated['biaya_id'] ?? null,
                'jenis' => $validated['jenis'],
                'kategori' => $validated['kategori'] ?? 'pendaftaran',
                'nominal' => $validated['nominal'],
                'bulan' => now()->toDateString(),
                'total' => $validated['nominal'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Data keuangan berhasil disimpan',
        ]);
    }

    /**
     * Show the form for editing the specified keuangan record.
     */
    public function edit(Keuangan $keuangan)
    {
        return response()->json([
            'keuangan' => $keuangan->load(['pembayaran', 'user', 'acara', 'biaya', 'pendaftaran']),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'acaras' => Acara::select('id', 'name_acara')->orderBy('name_acara')->get(),
            'biayas' => Biaya::select('id', 'name_biaya', 'nominal')->orderBy('name_biaya')->get(),
        ]);
    }

    /**
     * Update the specified keuangan record.
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        // Bersihkan titik (thousands separator Indonesia) dari nominal
        $request->merge([
            'nominal' => str_replace('.', '', $request->nominal ?? ''),
        ]);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'acara_id' => 'nullable|exists:acaras,id',
            'biaya_id' => 'nullable|exists:biayas,id',
            'jenis' => 'nullable|string|in:pemasukan,pengeluaran',
            'kategori' => 'nullable|string|max:255',
            'nominal' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $keuangan->update($validated);

        return response()->json([
            'message' => 'Data keuangan berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified keuangan record.
     */
    public function destroy(Keuangan $keuangan)
    {
        DB::transaction(function () use ($keuangan) {
            // Also delete related pembayaran if exists
            if ($keuangan->pembayaran) {
                $keuangan->pembayaran->delete();
            }
            $keuangan->delete();
        });

        return response()->json([
            'message' => 'Data keuangan berhasil dihapus',
        ]);
    }

    /**
     * Confirm a payment (konfirmasi pembayaran).
     */
    public function konfirmasi($pembayaranId)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($pembayaranId);

            DB::transaction(function () use ($pembayaran) {
                $pembayaran->update(['status' => 'lunas']);

                // Check if keuangan record exists, if not create one
                $keuangan = Keuangan::where('pembayaran_id', $pembayaran->id)->first();
                if (!$keuangan) {
                    $pendaftaran = $pembayaran->pendaftaran;
                    $nominal = $pendaftaran?->acaras?->biaya?->nominal ?? 0;

                    Keuangan::create([
                        'user_id' => $pembayaran->user_id,
                        'acara_id' => $pembayaran->acara_id,
                        'pendaftaran_id' => $pembayaran->pendaftaran_id,
                        'pembayaran_id' => $pembayaran->id,
                        'pembayarans_id' => $pembayaran->id,
                        'biaya_id' => $pendaftaran?->acaras?->biaya_id,
                        'jenis' => 'pemasukan',
                        'kategori' => 'pendaftaran',
                        'nominal' => $nominal,
                        'bulan' => now()->toDateString(),
                        'total' => $nominal,
                    ]);
                }
            });

            return response()->json([
                'message' => 'Pembayaran berhasil dikonfirmasi',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal konfirmasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check Midtrans payment status.
     */
    public function checkMidtransStatus($pembayaranId)
    {
        try {
            $pembayaran = Pembayaran::with('pendaftaran')->findOrFail($pembayaranId);

            if (!$pembayaran->pendaftaran) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
            }

            $orderId = 'PEM-' . $pembayaran->pendaftaran_id . '-' . ($pembayaran->created_at->timestamp ?? time());

            $midtrans = new MidtransService();
            $status = $midtrans->getTransactionStatus($orderId);

            return response()->json([
                'order_id' => $status->order_id ?? $orderId,
                'status' => $status->transaction_status ?? 'unknown',
                'payment_type' => $status->payment_type ?? '-',
                'gross_amount' => $status->gross_amount ?? 0,
                'transaction_time' => $status->transaction_time ?? '-',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal cek status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Load reference data (users, acaras, biayas) for AJAX requests.
     */
    public function loadData()
    {
        return response()->json([
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'acaras' => Acara::select('id', 'name_acara')->orderBy('name_acara')->get(),
            'biayas' => Biaya::select('id', 'name_biaya', 'nominal')->orderBy('name_biaya')->get(),
        ]);
    }
}
