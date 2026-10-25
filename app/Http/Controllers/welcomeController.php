<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use App\Models\Berita;
use App\Models\Profil;
use App\Models\Struktur;
use App\Models\Devisi;
use App\Models\Aspirasi;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Keuangan;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;

class welcomeController extends Controller
{
    public function index(Request $request)
    {
        $acaras = Acara::where('tipe', 'eksternal')->where('status', 'approved')->get();

        $acaras_count = $acaras->where('status', '=', 'approved')->count();

        $user = User::with('pendaftaran.acaras')->find(auth()->id());

        $pendaftarans = Pendaftaran::with('users.acaras')->where('user_id', auth()->id())->get();
        $beritas = Berita::all();
        $profil = Profil::first() ?? new Profil();

        $devisiList = Devisi::orderBy('name_devisi', 'asc')->get();

        // ✨ Leadership: jabatan 1-5 (Pembina, Kahim, Wakahim, Sekretaris, Bendahara)
        // Gunakan all() agar bisa di-group lalu difilter
        $allStrukturs = Struktur::with(['user', 'jabatan', 'devisi'])
            ->orderBy('jabatan_id', 'asc')
            ->orderBy('devisi_id', 'asc')
            ->get();

        // Pemisahan: Leadership (punya jabatan_id) vs Divisi (punya devisi_id)
        $strukturs = $allStrukturs->filter(fn($s) => !is_null($s->jabatan_id))->values();
        $devisis = $allStrukturs->filter(fn($s) => !is_null($s->devisi_id))->values();

        // Group leadership by jabatan_id
        $leadershipByJabatan = $strukturs->groupBy('jabatan_id');

        // Group divisi by devisi_id
        $devisiByGroup = $devisis->groupBy('devisi_id');

        // Stats count untuk hero (real-time)
        $count = [
            'user' => User::count(),
            'struktur' => Struktur::count(),
            'acara' => $acaras_count,
            'berita' => $beritas->count(),
            'pendaftaran' => Pendaftaran::count(),
            'pembayaran' => Pembayaran::whereIn('status', ['dibayar', 'lunas'])->count(),
            'aspirasi' => Aspirasi::count(),
            'dokumentasi' => \App\Models\Dokumentasi::count(),
        ];

        // Total nominal pembayaran sukses
        $totalPemasukan = Keuangan::where('pembayaran_id')->sum('pembayaran_id');

        return view('welcome', compact(
            'acaras', 'beritas', 'profil',
            'strukturs', 'devisiList', 'devisis',
            'leadershipByJabatan', 'devisiByGroup',
            'user', 'pendaftarans', 'acaras_count',
            'count', 'totalPemasukan',
        ));
    }

    public function acara(Request $request)
{
    $validated = $request->validate([
        'acaras_id' => 'required|exists:acaras,id',
        'like' => 'nullable|string|max:255',
        'dislike' => 'nullable|string|max:255',
        'Masukkan' => 'nullable|string|max:1000',
    ]);

    Aspirasi::create([
        'acaras_id' => $validated['acaras_id'],
        'like' => $validated['like'] ?? null,
        'dislike' => $validated['dislike'] ?? null,
        'Masukkan' => $validated['Masukkan'] ?? null,
    ]);

    

    return back()->with('success', 'Data berhasil disimpan.');
}

    public function pendaftaranIndex()
    {
        $user = auth()->user();
        $acaras = Acara::with(['pendaftarans.users', 'biaya', 'syarat'])->get();
        return view('pendaftaran.index', compact('user', 'acaras'));
    }

    public function pendaftaranStore(Request $request)
    {
        $validated = $request->validate([
        'user_id' => auth()->check() ? 'required|exists:users,id' : 'nullable',
        'NO_HP' => auth()->check() ? 'required|string|max:255' : 'nullable',
        'nama_pendaftar' => 'required|string|max:255',
        'acaras_id' => 'required|exists:acaras,id',
        'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $path = $request->file('file')->store('file-pendaftaran', 'public');

    Pendaftaran::create([
        'user_id' => auth()->check() ? auth()->id() : null,
        'NO_HP' => $validated['NO_HP'],
        'nama_pendaftar' => $validated['nama_pendaftar'],
        'acaras_id' => $validated['acaras_id'],
        'file' => $path,
        'status' => 'diajukan',
    ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function pembayaranIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $user_id = auth()->id();

        $pendaftarans = Pendaftaran::with(['acaras.biaya', 'pembayaran'])
            ->where('user_id', $user_id)
            ->latest()
            ->first();

        // Get existing payment if any
        $existingPembayaran = $pendaftarans?->pembayaran;

        // Generate payment code (Order ID)
        $paymentCode = null;
        if ($pendaftarans) {
            $paymentCode = 'PEM-' . $pendaftarans->id . '-' . time();
        }

        // Generate Midtrans Snap token
        $snapToken = null;
        $clientKey = null;
        if ($pendaftarans && $pendaftarans->acaras?->biaya) {
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

        return view('pembayaran.index', compact(
            'pendaftarans',
            'existingPembayaran',
            'snapToken',
            'clientKey',
            'paymentCode'
        ));
    }

    public function pembayaranStore(Request $request)
{
        $validated = $request->validate([
            'pendaftaran_id' => ['required', 'exists:pendaftarans,id'],
            'jenis' => ['required', 'in:kredit,cash'],

            // wajib upload jika kredit
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

        $jumlahBayar = $pendaftaran->acaras?->biaya?->nominal ?? 0;

        DB::transaction(function () use ($request, $validated, $pendaftaran, $jumlahBayar) {

            $path = null;

            // default status
            $status = 'belum_dibayar';

            if ($validated['jenis'] == 'kredit') {

                $path = $request->file('bukti_pembayaran')
                    ->store('bukti_pembayaran', 'public');

                $status = 'dibayar';
            }

            // simpan pembayaran
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

            // update pendaftaran
            $pendaftaran->update([
                'jenis' => $validated['jenis'],
                'bukti_pembayaran' => $path,
                'status' => 'diajukan',
            ]);
        });

        return redirect()
            ->route('welcome')
            ->with('success', 'Pembayaran berhasil dikirim.');
    }

    

    public function beritaIndex()
    {
        $beritas = Berita::all();

        $aspirasis = Aspirasi::with('berita')->where('Masukkan', '!=', null)->get();
        return view('berita', compact('beritas', 'aspirasis'));
    }

    public function tentangKami()
    {
        $profil = Profil::first() ?? new Profil();
        return view('tentang_kami', compact('profil'));
    }

    public function aspirasi()
    {
        $validated = request()->validate([
            'Masukkan' => 'required|string|max:1000',
        ]);

        Aspirasi::create([
            'like' => null,
            'dislike' => null,
            'Masukkan' => $validated['Masukkan'],
        ]);

        return back()->with('success', 'Data berhasil disimpan.');
    }

    public function berita(Request $request)
    {
        $validated = $request->validate([
            'beritas_id' => 'required|exists:beritas,id',
            'like' => 'nullable|string|max:255',
            'dislike' => 'nullable|string|max:255',
            'Masukkan' => 'nullable|string|max:1000',
        ]);

        Aspirasi::create([
            'beritas_id' => $validated['beritas_id'],
            'like' => $validated['like'] ?? null,
            'dislike' => $validated['dislike'] ?? null,
            'Masukkan' => $validated['Masukkan'] ?? null,
        ]);

        return back()->with('success', 'Data berhasil disimpan.');
    }
}
