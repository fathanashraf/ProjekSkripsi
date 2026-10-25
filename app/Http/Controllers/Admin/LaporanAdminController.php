<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('acara');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_laporan', 'like', "%{$search}%")
                  ->orWhereHas('acara', fn($a) => $a->where('name_acara', 'like', "%{$search}%"));
            });
        }

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporans = $query->latest()->paginate(10)->withQueryString();
        $acaras = Acara::select('id', 'name_acara')->orderBy('name_acara')->get();

        // Stats
        $totalLaporan = Laporan::count();
        $totalProposal = Laporan::where('jenis', 'proposal')->count();
        $totalLpj = Laporan::where('jenis', 'lpj')->count();
        $totalSk = Laporan::where('jenis', 'sk')->count();
        $totalLengkap = Laporan::where('jenis', 'lengkap')->count();
        $pendingApproval = Laporan::where('status', 'diajukan')->count();
        $approvedCount = Laporan::where('status', 'approved')->count();

        return view('admin.laporan.index', compact(
            'laporans', 'acaras',
            'totalLaporan', 'totalProposal', 'totalLpj', 'totalSk', 'totalLengkap',
            'pendingApproval', 'approvedCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'acaras_id'    => ['required', 'exists:acaras,id'],
            'jenis'       => ['required', 'in:proposal,lpj,sk,lengkap'],
            'nama_laporan' => ['required', 'string', 'max:255'],
            'tanggal'     => ['required', 'date'],
        ]);

        $validated['status'] = 'diajukan';
        Laporan::create($validated);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'acaras_id'    => ['required', 'exists:acaras,id'],
            'jenis'       => ['required', 'in:proposal,lpj,sk,lengkap'],
            'nama_laporan' => ['required', 'string', 'max:255'],
            'tanggal'     => ['required', 'date'],
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function generate(Acara $acara)
    {
        if ($acara->status === 'disetujui') {
            $acara->generateLaporan();
        }

        return redirect()->route('admin.acara.index')
            ->with('success', 'Laporan berhasil dihasilkan.');
    }
}
