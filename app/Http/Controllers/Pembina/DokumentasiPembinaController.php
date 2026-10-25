<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dokumentasi;
use App\Models\Acara;

class DokumentasiPembinaController extends Controller
{
    public function index()
    {
        $dokumentasis = Dokumentasi::with('acara')
        ->latest()
        ->get();

    $acaras = Acara::all();

    return view('pembina.dokumentasi.index', compact(
        'dokumentasis',
        'acaras'
    ));
    }
}
