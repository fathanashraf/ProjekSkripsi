<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranAdminController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['users', 'acaras', 'pembayaran'])
            ->latest()
            ->paginate(10);

        $userOptions = User::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->map(fn ($u) => [
                'value' => $u->id,
                'label' => $u->name,
            ])->values();

        $users = User::all();
            
        $acaraOptions = Acara::select('id', 'name_acara')
            ->orderBy('name_acara')
            ->get()
            ->map(fn ($a) => [
                'value' => $a->id,
                'label' => $a->name_acara,
            ])->values();

        $statusOptions = [
            ['value' => 'diajukan', 'label' => 'Diajukan'],
            ['value' => 'diterima', 'label' => 'Diterima'],
            ['value' => 'dibayar', 'label' => 'Lunas'],
            ['value' => 'ditolak', 'label' => 'Ditolak'],
        ];

        return view('admin.pendaftaran.index', compact(
            'pendaftarans',
            'users',
            'userOptions',
            'acaraOptions',
            'statusOptions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'acaras_id' => ['required', 'exists:acaras,id'],
            'status' => ['required', 'in:pending,diajukan,diterima,dibayar,ditolak'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')
                ->store('pendaftaran', 'public');
        }

        Pendaftaran::create($validated);

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'acaras_id' => ['required', 'exists:acaras,id'],
            'status' => ['required', 'in:pending,diajukan,diterima,dibayar,ditolak'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('file')) {
            if ($pendaftaran->file && Storage::disk('public')->exists($pendaftaran->file)) {
                Storage::disk('public')->delete($pendaftaran->file);
            }

            $validated['file'] = $request->file('file')
                ->store('pendaftaran', 'public');
        }

        $pendaftaran->update($validated);

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function approve(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update([
            'status' => Pendaftaran::STATUS_DITERIMA
        ]);

        $this->notifyPendaftaran($pendaftaran, Pendaftaran::STATUS_DITERIMA);

        return response()->json([
            'message' => 'Pendaftaran disetujui. Mahasiswa sekarang dapat melakukan pembayaran.',
        ], 200);
    }

    public function reject(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update([
            'status' => Pendaftaran::STATUS_DITOLAK
        ]);

        $this->notifyPendaftaran($pendaftaran, Pendaftaran::STATUS_DITOLAK);

        return response()->json([
            'message' => 'Pendaftaran ditolak.',
        ], 200);
    }

    /**
     * Kirim notifikasi ke mahasiswa terkait status pendaftaran.
     */
    private function notifyPendaftaran(Pendaftaran $pendaftaran, string $status): void
    {
        $user = $pendaftaran->users;
        if (!$user) {
            return;
        }

        try {
            $user->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, $status));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi pendaftaran', [
                'pendaftaran_id' => $pendaftaran->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->file && Storage::disk('public')->exists($pendaftaran->file)) {
            Storage::disk('public')->delete($pendaftaran->file);
        }

        $pendaftaran->delete();

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}