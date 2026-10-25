<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Acara;
use App\Models\Berita;
use App\Models\User;
use App\Models\Profil;
use App\Models\Aspirasi;

class DashboardUserController extends Controller
{
    public function index()
    {
        $title = 'Dashboard User HIMANIKKA';
        $acaras = Acara::with('user')->latest()->get();
        $beritas = Berita::with('user')->latest()->get();
        $profils = Profil::first('name_instansi');

        $count = [
            'acara' => Acara::count(),
            'berita' => Berita::count(),
            'user' => User::count(),
        ];
        return view('Mahasiswa.beranda.index', compact('title', 'acaras', 'beritas', 'count', 'profils'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => ['required', 'exists:users,id'],
            'beritas_id' => 'required|exists:beritas,id',
            'like' => 'nullable|string|max:255',
            'dislike' => 'nullable|string|max:255',
            'Masukkan' => 'nullable|string|max:1000',
        ]);

        Aspirasi::create($validated);

        return back()->with('success', 'Aspirasi berhasil dikirim.');
    }
}
