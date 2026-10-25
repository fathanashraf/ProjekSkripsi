<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    /**
     * Tampilkan halaman sertifikat untuk peserta.
     */
    public function index()
    {
        $user = auth()->user();

        $acara = Acara::with(['pendaftarans.users', 'biaya', 'syarat'])->get();

        // Ambil pendaftaran user yang sudah lunas pembayarannya
        $pendaftarans = Pendaftaran::with(['acaras', 'pembayaran'])
            ->where('user_id', $user->id)
            ->disetujui()
            ->whereHas('pembayaran', function ($q) {
                $q->whereIn('status', ['dibayar', 'lunas']);
            })
            ->latest()
            ->get();

        return view('Admin.sertifikat.index', compact('pendaftarans', 'user', 'acara'));
    }

    /**
     * Tampilkan sertifikat untuk di-print.
     */
    public function show($pendaftaranId)
    {
        $user = auth()->user();

        $pendaftaran = Pendaftaran::with(['acaras', 'users'])
            ->where('id', $pendaftaranId)
            ->where('user_id', $user->id)
            ->disetujui()
            ->firstOrFail();

        $acara = $pendaftaran->acaras;
        $peserta = $pendaftaran->users ?? $user;

        return view('Mahasiswa.sertifikat.cetak', compact('pendaftaran', 'acara', 'peserta'));
    }

    /**
     * Tampilkan sertifikat untuk ALL peserta oleh admin (by acara).
     * Route: admin/acara/{acara}/sertifikat
     */
    public function adminByAcara($acaraId)
    {
        $acara = Acara::findOrFail($acaraId);

        $pendaftarans = Pendaftaran::with(['users'])
            ->where('acaras_id', $acaraId)
            ->disetujui()
            ->get();

        return view('admin.sertifikat.index', compact('acara', 'pendaftarans'));
    }
}
