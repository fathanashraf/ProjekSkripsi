<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Aspirasi;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::all();
        return view('Mahasiswa.berita.index', compact('beritas'));
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

    Aspirasi::create([
        'users_id' => $validated['users_id'],
        'beritas_id' => $validated['beritas_id'],
        'like' => $validated['like'] ?? null,
        'dislike' => $validated['dislike'] ?? null,
        'Masukkan' => $validated['Masukkan'] ?? null,
    ]);

    

    return back()->with('success', 'Data berhasil disimpan.');
}
}