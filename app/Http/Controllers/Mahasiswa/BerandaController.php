<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Acara;
use App\Models\Berita;
use App\Models\Aspirasi;

class BerandaController extends Controller
{
    public function index()
    {
        $acaras = Acara::with('user')->latest()->get();
        $beritas = Berita::with('user')->latest()->get();

        $count = [
            'acara' => Acara::count(),
            'user' => User::count(),
            'berita' => Berita::count(),
        ];

        $profils = Profil::first('name_instansi');

        return view('Mahasiswa.beranda.index', compact('acaras', 'beritas', 'count', 'profils'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'users_id' => ['required', 'exists:users,id'],
        'Masukkan' => 'nullable|string|max:1000',
    ]);

    Aspirasi::create([
        'users_id' => $validated['users_id'],
        'Masukkan' => $validated['Masukkan'] ?? null,
    ]);

    return back()->with('success', 'Aspirasi berhasil disimpan.');
}
}
