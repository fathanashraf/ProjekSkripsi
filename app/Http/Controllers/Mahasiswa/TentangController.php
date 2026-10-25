<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        $profil = Profil::first();
        return view('Mahasiswa.tentang.index', compact('profil'));
    }
}
