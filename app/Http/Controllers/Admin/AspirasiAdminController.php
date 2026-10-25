<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Aspirasi;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;

class AspirasiAdminController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::with(['user', 'acara', 'berita'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Aspirasi::count(),
            'pending' => Aspirasi::where('status', 'pending')->count(),
            'proses' => Aspirasi::where('status', 'proses')->count(),
            'selesai' => Aspirasi::where('status', 'selesai')->count(),
        ];

        $users = User::select('id', 'name')->orderBy('name')->get();
        $acaras = Acara::select('id', 'name_acara')->orderBy('name_acara')->get();
        $beritas = Berita::select('id', 'name_berita')->orderBy('name_berita')->get();

        $aspirasiFormPayload = [
            'mode' => 'form',
            'title' => 'Tambah Aspirasi',
            'formAction' => route('admin.aspirasi.store'),
            'method' => 'POST',
            'fields' => [
                ['name' => 'users_id', 'label' => 'Pengirim', 'type' => 'select', 'options' => $users->map(fn ($u) => ['value' => $u->id, 'label' => $u->name])],
                ['name' => 'acaras_id', 'label' => 'Acara', 'type' => 'select', 'options' => $acaras->map(fn ($a) => ['value' => $a->id, 'label' => $a->name_acara])],
                ['name' => 'beritas_id', 'label' => 'Berita', 'type' => 'select', 'options' => $beritas->map(fn ($b) => ['value' => $b->id, 'label' => $b->name_berita])],
                ['name' => 'like', 'label' => 'Like', 'type' => 'text'],
                ['name' => 'dislike', 'label' => 'Dislike', 'type' => 'text'],
                ['name' => 'Masukkan', 'label' => 'Masukkan', 'type' => 'textarea', 'full' => true],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'proses', 'label' => 'Diproses'],
                    ['value' => 'selesai', 'label' => 'Selesai'],
                ]],
            ],
            'data' => ['status' => 'pending'],
        ];

        return view(
            'admin.aspirasi.index',
            compact('aspirasis', 'stats', 'users', 'acaras', 'beritas', 'aspirasiFormPayload')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        Aspirasi::create($validated);

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil ditambahkan.');
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        $validated = $request->validate($this->rules());

        $aspirasi->update($validated);

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'users_id' => ['nullable', 'exists:users,id'],
            'acaras_id' => ['nullable', 'exists:acaras,id'],
            'beritas_id' => ['nullable', 'exists:beritas,id'],
            'like' => ['nullable', 'string', 'max:255'],
            'dislike' => ['nullable', 'string', 'max:255'],
            'Masukkan' => ['nullable', 'string'],
            'status' => ['nullable', 'in:pending,proses,selesai'],
        ];
    }
}