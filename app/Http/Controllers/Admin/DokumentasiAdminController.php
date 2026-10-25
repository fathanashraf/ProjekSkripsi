<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiAdminController extends Controller
{
    public function index()
    {
        $acaras = Acara::with('dokumentasis')
            ->select('id', 'name_acara', 'tanggal', 'tempat', 'keterangan', 'thumnail')
            ->orderBy('name_acara')
            ->get();

        $dokumentasis = Dokumentasi::with('acara')
            ->latest()
            ->get();

        return view('admin.dokumentasi.index', compact('acaras', 'dokumentasis'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'acara_id' => ['required', 'exists:acaras,id'],
        'name_dokumentasi' => ['required', 'string', 'max:255'],
        'file' => ['required', 'array'],
        'file.*' => ['required', 'file', 'mimes:zip,rar,jpg,jpeg,png,pdf', 'max:99999'],
    ]);

    foreach ($request->file('file') as $file) {
        $path = $file->store('dokumentasi', 'public');

        Dokumentasi::create([
            'acara_id' => $validated['acara_id'],
            'name_dokumentasi' => $validated['name_dokumentasi'],
            'file' => $path,
        ]);
    }

    return redirect()->route('admin.dokumentasi.index')
        ->with('success', 'Dokumentasi berhasil ditambahkan.');
}

    public function update(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        $validated = $request->validate([
            'name_dokumentasi' => ['required', 'string', 'max:255'],
            'acara_id' => ['required', 'exists:acaras,id'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('file')) {
            if ($dokumentasi->file) {
                Storage::disk('public')->delete($dokumentasi->file);
            }

            $validated['file'] = $request->file('file')->store('dokumentasi', 'public');
        }

        $dokumentasi->update($validated);

        return redirect()
            ->route('admin.dokumentasi.index')
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->file) {
            Storage::disk('public')->delete($dokumentasi->file);
        }

        $dokumentasi->delete();

        return redirect()
            ->route('admin.dokumentasi.index')
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }
}