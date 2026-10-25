<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use App\Models\User;
use App\Models\Devisi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturAdminController extends Controller
{
    public function index()
    {
        $title = 'Struktur HIMANIKKA';

        $strukturs = Struktur::with(['user', 'devisi', 'jabatan'])->get();
        $users = User::select('id', 'name')->orderBy('name')->get();
        $devisis = Devisi::select('id', 'name_devisi')->orderBy('name_devisi')->get();
        $jabatans = Jabatan::select('id', 'name_jabatan')->orderBy('name_jabatan')->get();

        $posisiOptions = [
            ['value' => 'koordinator', 'label' => 'Koordinator'],
            ['value' => 'anggota', 'label' => 'Anggota'],
        ];

        return view('admin.struktur.index', compact(
            'title',
            'strukturs',
            'users',
            'devisis',
            'jabatans',
            'posisiOptions'
        ));
    }

    public function create()
    {
        $title = 'Tambah Struktur HIMANIKKA';

        $users = User::select('id', 'name')->orderBy('name')->get();
        $devisis = Devisi::select('id', 'name_devisi')->orderBy('name_devisi')->get();
        $jabatans = Jabatan::select('id', 'name_jabatan')->orderBy('name_jabatan')->get();

        $posisiOptions = [
            ['value' => 'koordinator', 'label' => 'Koordinator'],
            ['value' => 'anggota', 'label' => 'Anggota'],
        ];

        return view('admin.struktur.create', compact(
            'title',
            'users',
            'devisis',
            'jabatans',
            'posisiOptions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'devisi_id' => ['nullable', 'exists:devisis,id'],
            'jabatan_id' => ['nullable', 'exists:jabatans,id'],
            'posisi' => ['nullable', 'string'],
            'masa_jabatan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        Struktur::create([
            'user_id' => $validated['user_id'],
            'devisi_id' => $validated['devisi_id'] ?? null,
            'jabatan_id' => $validated['jabatan_id'] ?? null,
            'posisi' => $validated['posisi'] ?? null,
            'masa_jabatan' => $validated['masa_jabatan'] ?? null,
            'foto' => $validated['foto'] ?? null,
        ]);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Struktur berhasil ditambahkan.');
    }

    public function show(Struktur $struktur)
    {
        $struktur->load(['user', 'devisi', 'jabatan']);
        return response()->json($struktur);
    }

    public function update(Request $request, Struktur $struktur)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'devisi_id' => ['nullable', 'exists:devisis,id'],
            'jabatan_id' => ['nullable', 'exists:jabatans,id'],
            'posisi' => ['nullable', 'string'],
            'masa_jabatan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($struktur->foto && Storage::disk('public')->exists($struktur->foto)) {
                Storage::disk('public')->delete($struktur->foto);
            }

            $validated['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        $struktur->update([
            'user_id' => $validated['user_id'],
            'devisi_id' => $validated['devisi_id'] ?? null,
            'jabatan_id' => $validated['jabatan_id'] ?? null,
            'posisi' => $validated['posisi'] ?? null,
            'masa_jabatan' => $validated['masa_jabatan'] ?? null,
            'foto' => $validated['foto'] ?? $struktur->foto,
        ]);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Struktur berhasil diupdate.');
    }

    public function destroy(Struktur $struktur)
    {
        if ($struktur->foto && Storage::disk('public')->exists($struktur->foto)) {
            Storage::disk('public')->delete($struktur->foto);
        }

        $struktur->delete();

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Struktur berhasil dihapus.');
    }
}