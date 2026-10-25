<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Profil;

class TentangPembinaController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Profil HIMANIKKA';

        // Ambil data profil
        $profil = Profil::first();

        return view('pembina.tentang.index', compact(
            'title',
            'profil'
        ));
    }
}