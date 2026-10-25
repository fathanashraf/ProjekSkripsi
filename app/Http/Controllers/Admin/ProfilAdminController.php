<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use Illuminate\Support\Facades\Storage;

class ProfilAdminController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Profil HIMANIKKA';
        $profil = Profil::first() ?? new Profil();

        return view('admin.profil.index', compact('title', 'profil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->handleUploads($request, $validated);

        Profil::create($validated);

        return back()->with('success', 'Profil berhasil ditambahkan.');
    }

    public function update(Request $request, Profil $profil)
    {
        $validated = $request->validate($this->rules($profil));

        // pertahankan file lama bila tidak ada upload baru
        foreach (['logo', 'ad_art', 'mars_mahasiswa', 'hymne_teknik'] as $field) {
            if (! $request->hasFile($field)) {
                $validated[$field] = $profil->{$field};
            }
        }

        $this->handleUploads($request, $validated);

        $profil->update($validated);

        return back()->with('success', 'Profil berhasil diupdate.');
    }

    private function rules(?Profil $profil = null): array
    {
        $required = $profil ? 'nullable' : 'required';

        return [
            'name_instansi' => 'required|string|max:255',
            'singkatan' => 'required|string|max:255',
            'sejarah' => 'required|string',
            'alamat' => 'required|string|max:255',
            'logo' => $required.'|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tahun_berdiri' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'tujuan' => 'required|string',
            'fungsi' => 'nullable|string',
            'ad_art' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'mars_mahasiswa' => 'nullable|file|mimes:mp3,mp4,m4a,m4v|max:102400',
            'hymne_teknik' => 'nullable|file|mimes:mp3,mp4,m4a,m4v|max:102400',
        ];
    }

    /**
     * Simpan file baru dan hapus file lama yang digantikan.
     */
    private function handleUploads(Request $request, array &$validated): void
    {
        $files = [
            'logo' => 'uploads/profil',
            'ad_art' => 'uploads/profil',
            'mars_mahasiswa' => 'uploads/profil',
            'hymne_teknik' => 'uploads/profil',
        ];

        foreach ($files as $field => $directory) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $old = $validated[$field] ?? null;

            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }

            $validated[$field] = $request->file($field)->store($directory, 'public');
        }
    }
}