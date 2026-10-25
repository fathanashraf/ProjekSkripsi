<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\User;
use App\Notifications\AcaraCreatedNotification;
use App\Models\Pendaftaran;

class AcaraController extends Controller
{
    public function index()
    {
        $acaras = Acara::where('status', 'approved')->get();

        $acaras_count = $acaras->where('status', '=', 'approved')->count();

        $user = User::with('pendaftaran.acaras')->find(auth()->id());

        $pendaftarans = Pendaftaran::with('users.acaras')->where('user_id', auth()->id())->get();
        return view('Mahasiswa.acara.index', compact('acaras', 'pendaftarans', 'acaras_count', 'user'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'users_id' => ['required', 'exists:users,id'],
        'acaras_id' => 'required|exists:acaras,id',
        'like' => 'nullable|string|max:255',
        'dislike' => 'nullable|string|max:255',
        'Masukkan' => 'nullable|string|max:1000',
    ]);

    Aspirasi::create([
        'users_id' => $validated['users_id'],
        'acaras_id' => $validated['acaras_id'],
        'like' => $validated['like'] ?? null,
        'dislike' => $validated['dislike'] ?? null,
        'Masukkan' => $validated['Masukkan'] ?? null,
    ]);

    

    return back()->with('success', 'Data berhasil disimpan.');
}
}
