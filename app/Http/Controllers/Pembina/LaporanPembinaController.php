<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanPembinaController extends Controller
{
    protected ExportService $export;

    public function __construct(ExportService $export)
    {
        $this->export = $export;
    }

    public function index()
    {
        $laporans = Laporan::with('acara.user')->latest()->paginate(10);

        return view('pembina.laporan.index', compact('laporans'));
    }

    public function approve(Laporan $laporan)
    {
        if ($laporan->status !== 'diajukan') {
            return back()->with('error', 'Laporan ini sudah diproses.');
        }

        // Update status dulu
        $laporan->update(['status' => 'approved']);

        // Reload dengan relasi yang dibutuhkan untuk PDF
        $laporan->load('acara.user');

        // Generate PDF otomatis
        try {
            [$view, $data] = $this->export->prepareReportData($laporan);

            $jenis = $laporan->jenis;
            $filename = $jenis . '-' . $laporan->id . '-' . now()->format('Ymd_His');

            // Simpan PDF ke storage
            $filePath = $this->export->savePdf($view, $data, $filename);

            // Update file path di database
            $laporan->update(['file' => $filePath]);

        } catch (\Exception $e) {
            Log::error('Gagal generate PDF otomatis untuk laporan #' . $laporan->id . ': ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Laporan berhasil disetujui dan PDF telah digenerate.');
    }

    public function reject(Request $request, Laporan $laporan)
    {
        if ($laporan->status !== 'diajukan') {
            return back()->with('error', 'Laporan ini sudah diproses.');
        }

        $validated = $request->validate([
            'catatan' => ['required', 'string', 'max:500'],
        ]);

        $laporan->update([
            'status' => 'rejected',
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
    }
}
