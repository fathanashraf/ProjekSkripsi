<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiPembinaController extends Controller
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

        return view(
            'pembina.aspirasi.index',
            compact('aspirasis', 'stats')
        );
    }

    public function proses(Aspirasi $aspirasi)
    {
        if ($aspirasi->status === 'selesai') {
            return back()->with('error', 'Aspirasi yang sudah selesai tidak dapat diproses.');
        }

        $aspirasi->update(['status' => 'proses']);

        return back()->with('success', 'Aspirasi berhasil diproses.');
    }

    public function selesai(Aspirasi $aspirasi)
    {
        $aspirasi->update(['status' => 'selesai']);

        return back()->with('success', 'Aspirasi berhasil diselesaikan.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();

        return back()->with('success', 'Aspirasi berhasil dihapus.');
    }
}