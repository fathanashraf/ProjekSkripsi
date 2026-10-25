<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\Syarat;

class BiayaAdminController extends Controller
{
    public function store(Request $request)
    {
        // Bersihkan titik (thousands separator Indonesia) dari nominal
        $request->merge([
            'nominal' => str_replace('.', '', (string) $request->input('nominal')),
        ]);

        $validated = $request->validate([
            'name_biaya' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|integer|min:0',
        ]);

        Biaya::create($validated);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function storeSyarat(Request $request)
    {
        $validated = $request->validate([
            'name_syarat' => 'required|string|max:255',
            'kebutuhan' => 'nullable|string',
        ]);
        Syarat::create($validated);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Syarat berhasil ditambahkan.');
    }
}
