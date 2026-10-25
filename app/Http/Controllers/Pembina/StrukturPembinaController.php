<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Struktur;

class StrukturPembinaController extends Controller
{
    public function index()
    {
        $title = 'Struktur Organisasi HIMANIKKA';

        $strukturs = Struktur::with([
            'user',
            'jabatan',
            'devisi'
        ])
        ->latest()
        ->get();


        return view('pembina.struktur.index', compact(
            'title',
            'strukturs'
        ));
    }
}