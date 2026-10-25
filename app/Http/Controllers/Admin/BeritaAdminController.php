<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaAdminController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('user')->latest()->paginate(10);
        $users = User::select('id', 'name')->orderBy('name')->get();

        $stats = [
            'total' => Berita::count(),
            'with_thumbnail' => Berita::whereNotNull('thumnail')->count(),
            'with_author' => Berita::whereNotNull('user_id')->count(),
        ];

        return view('admin.berita.index', compact('beritas', 'users', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_berita' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'thumnail' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        // Penulis default ke admin yang sedang login
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();

        if ($request->hasFile('thumnail')) {
            $validated['thumnail'] = $request->file('thumnail')->store('berita/thumnail', 'public');
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'name_berita' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'thumnail' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $validated['user_id'] = $validated['user_id'] ?? $berita->user_id;

        if ($request->hasFile('thumnail')) {
            if ($berita->thumnail && Storage::disk('public')->exists($berita->thumnail)) {
                Storage::disk('public')->delete($berita->thumnail);
            }

            $validated['thumnail'] = $request->file('thumnail')->store('berita/thumnail', 'public');
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->thumnail && Storage::disk('public')->exists($berita->thumnail)) {
            Storage::disk('public')->delete($berita->thumnail);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}