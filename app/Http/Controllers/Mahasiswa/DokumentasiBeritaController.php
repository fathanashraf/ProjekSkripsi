<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class DokumentasiBeritaController extends Controller
{
    public function index(){
        $beritas = Berita::all();
        return view ('mahasiswa.dokumentasi.berita.index', compact('beritas'));
    }
}
