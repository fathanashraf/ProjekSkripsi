<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaPembinaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('user')
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Berita::count(),
            'bulan_ini' => Berita::whereMonth('tanggal', now()->month)
                                ->whereYear('tanggal', now()->year)
                                ->count(),

            'hari_ini' => Berita::whereDate('tanggal', today())
                                ->count(),
        ];

        return view(
            'pembina.berita.index',
            compact('beritas', 'stats')
        );
    }
}