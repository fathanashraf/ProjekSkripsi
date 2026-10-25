<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;

class AcaraPembinaController extends Controller
{
    public function index(Request $request)
    {
        $acaras = Acara::with('user')
            ->withCount('pendaftarans')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total' => $acaras->count(),
            'approved' => $acaras->where('status', 'approved')->count(),
            'selesai' => $acaras->filter(fn ($a) => $a->tanggal && \Carbon\Carbon::parse($a->tanggal)->lt(now()))->count(),
            'total_peserta' => $acaras->sum('pendaftarans_count'),
        ];

        return view('pembina.acara.index', compact('acaras', 'stats'));
    }

    public function approve(Acara $acara)
    {
        if ($acara->status !== 'diajukan') {
            return back()->with('error', 'Acara ini tidak dapat dikonfirmasi.');
        }

        $acara->update(['status' => 'approved']);

        return back()->with('success', 'Acara berhasil dikonfirmasi.');
    }

    public function reject(Acara $acara)
    {
        if ($acara->status !== 'diajukan') {
            return back()->with('error', 'Acara ini tidak dapat ditolak.');
        }

        $acara->update(['status' => 'rejected']);

        return back()->with('success', 'Acara berhasil ditolak.');
    }
}