<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Acara;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $acaras = Acara::with(['pendaftarans.users', 'biaya', 'syarat'])->get();

        return view('Mahasiswa.pendaftaran.index', compact('user', 'acaras'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'acaras_id' => 'required|exists:acaras,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('file')->store('file-pendaftaran', 'public');

        Pendaftaran::create([
            'user_id' => auth()->id(),
            'acaras_id' => $validated['acaras_id'],
            'file' => $path,
            'status' => Pendaftaran::STATUS_DIAJUKAN,
        ]);

        return redirect()
            ->route('Mahasiswa.pembayaran.index')
            ->with('success', 'Pendaftaran berhasil dikirim. Pembayaran dapat dilakukan setelah disetujui admin.');
    }
}