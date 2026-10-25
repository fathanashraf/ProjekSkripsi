<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Syarat;
use App\Models\Biaya;
use App\Notifications\AcaraCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class AcaraAdminController extends Controller
{
    public function index()
    {
        $title = 'Acara HIMANIKKA';

        $acaras = Acara::with(['user', 'pendaftarans.users', 'syarat', 'biaya'])
            ->withCount('pendaftarans')
            ->latest()
            ->paginate(10);

        $users = User::select('id', 'name')->orderBy('name')->get();

        $syarats = Syarat::select('id', 'name_syarat')->get();

        $biayas = Biaya::select('id', 'nominal')->get();

        $stats = [
            'total_acara' => Acara::count(),
            'total_pendaftaran' => Pendaftaran::count(),
            'internal' => Acara::where('tipe', 'internal')->count(),
            'eksternal' => Acara::where('tipe', 'eksternal')->count(),
        ];

        // Menghitung total pendaftar per acara dalam format array sederhana
        $stats['total_pendaftar'] = [];
        foreach ($acaras as $acara) {
            $stats['total_pendaftar'][$acara->id] = $acara->pendaftarans_count;
        }

        return view('admin.acara.index', compact('acaras', 'stats', 'title', 'users', 'syarats', 'biayas'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['admin', 'superadmin'])
            ->select('id', 'name', 'email')
            ->get();

        $syarats = Syarat::select('id', 'name_syarat')->get();
        $biayas = Biaya::select('id', 'nominal')->get();

        return view('admin.acara.create', compact('users', 'syarats', 'biayas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_acara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'tempat' => 'nullable|string|max:255',
            'thumnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'user_id' => 'required|exists:users,id',
            'syarat_id' => 'required|exists:syarats,id',
            'biaya_id' => 'required|exists:biayas,id',
            'tipe' => 'required|in:internal,eksternal',
            'status' => 'nullable|in:diajukan,approved,rejected',
        ]);

        if ($request->hasFile('thumnail')) {
            $validated['thumnail'] = Storage::disk('public')->putFile('acara/thumbnail', $request->file('thumnail'));
        }

        Acara::create($validated);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    public function show(Acara $acara)
    {
        $acara->load(['user', 'syarat', 'biaya']);
        return view('admin.acara.show', compact('acara'));
    }

    public function edit(Acara $acara)
    {
        $users = User::whereIn('role', ['admin', 'superadmin'])
            ->select('id', 'name', 'email')
            ->get();

        $syarats = Syarat::select('id', 'name_syarat')->get();
        $biayas = Biaya::select('id', 'nominal')->get();

        return view('admin.acara.edit', compact('acara', 'users', 'syarats', 'biayas'));
    }

    public function update(Request $request, Acara $acara)
    {
        $validated = $request->validate([
            'name_acara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tempat' => 'nullable|string|max:255',
            'tipe' => 'required|in:internal,eksternal',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'thumnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'syarat_id' => 'required|exists:syarats,id',
            'biaya_id' => 'required|exists:biayas,id',
            'status' => 'nullable|in:diajukan,approved,rejected',
        ]);

        if ($request->hasFile('thumnail')) {
            if ($acara->thumnail && Storage::disk('public')->exists($acara->thumnail)) {
                Storage::disk('public')->delete($acara->thumnail);
            }

            $validated['thumnail'] = Storage::disk('public')->putFile('acara/thumbnail', $request->file('thumnail'));
        }

        $acara->update($validated);

        return redirect()->route('admin.acara.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Acara $acara)
    {
        if ($acara->thumnail && Storage::disk('public')->exists($acara->thumnail)) {
            Storage::disk('public')->delete($acara->thumnail);
        }

        // Hapus juga pendaftaran yang terkait
        $acara->pendaftarans()->delete();

        $acara->delete();

        return redirect()->route('admin.acara.index')
            ->with('success', 'Acara berhasil dihapus.');
    }

    public function syarat(Request $request)
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