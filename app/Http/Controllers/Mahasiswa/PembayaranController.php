<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Keuangan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $pendaftarans = Pendaftaran::with(['acaras.biaya', 'pembayaran'])
            ->where('user_id', $userId)
            ->latest()
            ->first();

        // Pendaftaran harus disetujui admin sebelum bisa bayar
        // (status 'dibayar' juga dianggap sudah lolos persetujuan)
        $sudahDisetujui = (bool) $pendaftarans?->isDisetujui();

        // Get existing payment if any
        $existingPembayaran = $sudahDisetujui ? $pendaftarans?->pembayaran : null;

        // Generate payment code (Order ID)
        $paymentCode = null;
        if ($sudahDisetujui && $pendaftarans && !$pendaftarans->isLunas()) {
            $paymentCode = 'PEM-' . $pendaftarans->id . '-' . time();
        }

        // Generate Midtrans Snap token
        $snapToken = null;
        $clientKey = null;
        if ($sudahDisetujui && !$pendaftarans->isLunas() && $pendaftarans->acaras?->biaya) {
            try {
                $midtrans = new MidtransService();
                $params = $midtrans->buildSnapParams($pendaftarans);
                $snapToken = $midtrans->createSnapToken($params);
                $clientKey = config('midtrans.client_key');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Midtrans snap token generation failed', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('Mahasiswa.pembayaran.index', compact(
            'pendaftarans',
            'existingPembayaran',
            'snapToken',
            'clientKey',
            'paymentCode',
            'sudahDisetujui'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => ['required', 'exists:pendaftarans,id'],
            'jenis' => ['required', 'in:kredit,cash'],

            'bukti_pembayaran' => [
                'nullable',
                'required_if:jenis,kredit',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
            'status' => ['required', 'in:menunggu,belum_dibayar,dibayar'],
        ]);

        $pendaftaran = Pendaftaran::with('acaras')
            ->where('id', $validated['pendaftaran_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$pendaftaran->isDisetujui()) {
            return redirect()
                ->route('Mahasiswa.pembayaran.index')
                ->with('error', 'Pendaftaran Anda belum disetujui admin. Pembayaran belum dapat dilakukan.');
        }

        if ($pendaftaran->isLunas()) {
            return redirect()
                ->route('Mahasiswa.pembayaran.index')
                ->with('error', 'Pembayaran untuk pendaftaran ini sudah lunas.');
        }

        $jumlahBayar = $pendaftaran->acaras?->biaya?->nominal ?? 0;

        DB::transaction(function () use ($request, $validated, $pendaftaran, $jumlahBayar) {
            $path = null;
            $status = 'belum_dibayar';

            if ($validated['jenis'] == 'kredit') {
                $path = $request->file('bukti_pembayaran')
                    ->store('bukti_pembayaran', 'public');
                $status = 'dibayar';
            }

            $pembayaran = Pembayaran::create([
                'user_id' => auth()->id(),
                'acara_id' => $pendaftaran->acaras_id,
                'pendaftaran_id' => $pendaftaran->id,
                'jenis' => $validated['jenis'],
                'bukti_pembayaran' => $path,
                'status' => $status,
            ]);

            if ($status === 'dibayar') {
                Keuangan::create([
                    'user_id' => auth()->id(),
                    'acara_id' => $pendaftaran->acaras_id,
                    'pendaftaran_id' => $pendaftaran->id,
                    'pembayarans_id' => $pembayaran->id,
                    'pembayaran_id' => $pembayaran->id,
                    'jenis' => 'pemasukan',
                    'kategori' => 'pendaftaran',
                    'nominal' => $jumlahBayar,
                    'bulan' => now()->toDateString(),
                    'total' => $jumlahBayar,
                    'biaya_id' => $pendaftaran->acaras?->biaya_id,
                ]);
            }

            // Tandai lunas di pendaftaran bila pembayaran sudah dikonfirmasi
            if ($status === 'dibayar') {
                $pendaftaran->update(['status' => Pendaftaran::STATUS_DIBAYAR]);
            }
        });

        return redirect()
            ->route('Mahasiswa.acara.index')
            ->with('success', 'Pembayaran berhasil dikirim.');
    }
}
