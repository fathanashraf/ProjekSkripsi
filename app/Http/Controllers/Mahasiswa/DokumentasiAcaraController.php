<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Acara;

class DokumentasiAcaraController extends Controller
{
    public function index()
    {
        // Ambil semua acara beserta dokumentasinya
        $acaras = Acara::with('dokumentasis')
            ->latest()
            ->get();

        return view('Mahasiswa.dokumentasi.acara.index', compact('acaras'));
    }
}