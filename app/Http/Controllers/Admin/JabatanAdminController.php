<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Devisi;

class JabatanAdminController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_jabatan' => ['required', 'string', 'max:255'],
        ]);

        Jabatan::create($validated);

        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function storeDevisi(Request $request)
    {
        $validated = $request->validate([
            'name_devisi' => ['required', 'string', 'max:255'],
        ]);

        Devisi::create($validated);

        return back()->with('success', 'Devisi berhasil ditambahkan.');
    }
}
