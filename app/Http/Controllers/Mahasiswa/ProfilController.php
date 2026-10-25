<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Halaman profil mahasiswa.
     *
     * Sebelumnya method ini kosong sehingga route Mahasiswa.profil.index
     * selalu melempar 500 "Call to undefined method ... index()".
     * Memakai view profil bersama karena sudah menangani role sendiri.
     */
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }
}
