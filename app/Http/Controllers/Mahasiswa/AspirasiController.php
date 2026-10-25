<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;

class AspirasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'acara_id' => 'required|exists:acara,id',
            'user_id' => 'required|exists:user,id',
            'berita_id' => 'required|exists:berita,id',
            'like' => 'nullable|string|max:255',
            'dislike' => 'nullable|string|max:255',
            'Masukkan' => 'nullable|string|max:1000',
            'status' => 'nullable|string|max:255',
        ]);

        Aspirasi::create($validated);

        return back()->with('success', 'Aspirasi berhasil dibuat!');
    }
}
