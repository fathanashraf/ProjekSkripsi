<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use App\Models\Devisi;
use Illuminate\Http\Request;

class StrukturController extends Controller
{
    public function index(Request $request)
    {
        $devisiList = Devisi::orderBy('name_devisi', 'asc')->get();

        // Ambil semua struktur dengan relasi
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

        return view('mahasiswa.struktur.index', compact(
            'strukturs', 'devisiList', 'devisis',
            'leadershipByJabatan', 'devisiByGroup'
        ));
    }
}