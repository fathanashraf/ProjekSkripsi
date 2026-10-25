<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Acara;
use App\Models\Dokumentasi;
use App\Models\Keuangan;
use App\Models\Laporan;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Services\ExportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    protected ExportService $export;

    public function __construct(ExportService $export)
    {
        $this->export = $export;
    }

    /**
     * Helper: Kirim CSV sebagai file download.
     * Excel Indonesia pakai separator semicolon (;) karena koma (,) dipakai
     * sebagai pemisah desimal.
     */
    private function streamCsv(string $filename, array $headers, $data, array $numericCols = [])
    {
        $responseHeaders = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($headers, $data, $numericCols) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            // Tulis header
            fputcsv($file, array_keys($headers), ';');

            // Tulis data
            $idx = 0;
            foreach ($data as $row) {
                $output = [];
                foreach ($headers as $colName => $_) {
                    $value = $row[$colName] ?? '';
                    // Kolom numerik: export angka murni tanpa format (biar bisa di-sum Excel)
                    if (in_array($colName, $numericCols) && is_numeric(str_replace(['.', ','], ['', '.'], $value))) {
                        $numStr = str_replace('.', '', (string) $value); // hapus titik ribuan
                        $numStr = str_replace(',', '.', $numStr); // koma desimal jadi titik
                        $output[] = is_numeric($numStr) ? (float) $numStr : $value;
                    } else {
                        $output[] = $value;
                    }
                    $idx++;
                }
                fputcsv($file, $output, ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $responseHeaders);
    }

    // ========================================================================
    //  KEUANGAN
    // ========================================================================

    public function keuanganCsv(Request $request)
    {
        $query = Keuangan::with(['user', 'acara', 'biaya']);
        if ($request->filled('jenis')) $query->where('jenis', $request->jenis);
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date')) $query->whereDate('created_at', '<=', $request->end_date);

        $data = $query->latest()->get()->map(fn($r) => [
            'No' => $r->id,
            'Tanggal' => $r->created_at->format('d/m/Y H:i'),
            'User' => $r->user?->name ?? '-',
            'Acara' => $r->acara?->name_acara ?? '-',
            'Jenis' => $r->jenis,
            'Kategori' => $r->kategori ?? '-',
            'Nominal (Rp)' => number_format($r->nominal, 0, ',', '.'),
            'Bulan' => $r->bulan ?? '-',
            'Keterangan' => $r->keterangan ?? '-',
        ]);

        ActivityLog::logExport('keuangan', 'CSV');
        return $this->streamCsv('keuangan-' . now()->format('Ymd'), [
            'No' => 'ID', 'Tanggal' => 'Tanggal', 'User' => 'User', 'Acara' => 'Acara',
            'Jenis' => 'Jenis', 'Kategori' => 'Kategori', 'Nominal (Rp)' => 'Nominal (Rp)',
            'Bulan' => 'Bulan', 'Keterangan' => 'Keterangan',
        ], $data, ['Nominal (Rp)']);
    }

    public function keuanganXls(Request $request)
    {
        $query = Keuangan::with(['user', 'acara', 'biaya']);
        if ($request->filled('jenis')) $query->where('jenis', $request->jenis);
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date')) $query->whereDate('created_at', '<=', $request->end_date);

        $rows = $query->latest()->get()->map(fn($r) => [
            'No' => $r->id,
            'Tanggal' => $r->created_at->format('d/m/Y H:i'),
            'User' => $r->user?->name ?? '-',
            'Acara' => $r->acara?->name_acara ?? '-',
            'Jenis' => ucfirst($r->jenis),
            'Kategori' => $r->kategori ?? '-',
            'Nominal (Rp)' => number_format($r->nominal, 0, ',', '.'),
            'Bulan' => $r->bulan ?? '-',
        ])->toArray();

        ActivityLog::logExport('keuangan', 'XLS');
        return $this->export->xls(
            'Laporan Keuangan HIMANIKKA',
            ['No' => 'No', 'Tanggal' => 'Tanggal', 'User' => 'User', 'Acara' => 'Acara',
             'Jenis' => 'Jenis', 'Kategori' => 'Kategori', 'Nominal (Rp)' => 'Nominal (Rp)', 'Bulan' => 'Bulan'],
            $rows, ['Nominal (Rp)'], 'keuangan-' . now()->format('Ymd')
        );
    }

    public function keuanganPdf(Request $request)
    {
        $query = Keuangan::with(['user', 'acara', 'biaya']);
        if ($request->filled('jenis')) $query->where('jenis', $request->jenis);
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date')) $query->whereDate('created_at', '<=', $request->end_date);

        $items = $query->latest()->get();

        ActivityLog::logExport('keuangan', 'PDF');
        return $this->export->pdf('exports.keuangan-pdf', [
            'judul' => 'Laporan Keuangan HIMANIKKA',
            'items' => $items,
        ], 'keuangan-' . now()->format('Ymd'));
    }

    // ========================================================================
    //  ACARA
    // ========================================================================

    public function acaraCsv()
    {
        $acaras = Acara::with(['user', 'biaya'])->withCount('pendaftarans')->latest()->get();

        $data = $acaras->map(fn($a) => [
            'No' => $a->id,
            'Nama Acara' => $a->name_acara,
            'Tanggal' => $a->tanggal ? \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') : '-',
            'Tempat' => $a->tempat ?? '-',
            'Tipe' => $a->tipe ?? '-',
            'Status' => $a->status ?? '-',
            'Jumlah Pendaftar' => $a->pendaftarans_count,
            'Biaya (Rp)' => $a->biaya ? number_format($a->biaya->nominal, 0, ',', '.') : '0',
            'Dibuat Oleh' => $a->user?->name ?? '-',
            'Tanggal Buat' => $a->created_at->format('d/m/Y H:i'),
        ]);

        ActivityLog::logExport('acara', 'CSV');
        return $this->streamCsv('acara-' . now()->format('Ymd'), [
            'No' => 'ID', 'Nama Acara' => 'Nama Acara', 'Tanggal' => 'Tanggal', 'Tempat' => 'Tempat',
            'Tipe' => 'Tipe', 'Status' => 'Status', 'Jumlah Pendaftar' => 'Jumlah Pendaftar',
            'Biaya (Rp)' => 'Biaya (Rp)', 'Dibuat Oleh' => 'Dibuat Oleh', 'Tanggal Buat' => 'Tanggal Buat',
        ], $data, ['Jumlah Pendaftar', 'Biaya (Rp)']);
    }

    public function acaraXls()
    {
        $acaras = Acara::with(['user', 'biaya'])->withCount('pendaftarans')->latest()->get();

        $rows = $acaras->map(fn($a) => [
            'No' => $a->id,
            'Nama Acara' => $a->name_acara,
            'Tanggal' => $a->tanggal ? \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') : '-',
            'Tempat' => $a->tempat ?? '-',
            'Tipe' => $a->tipe ?? '-',
            'Status' => ucfirst($a->status ?? '-'),
            'Pendaftar' => $a->pendaftarans_count,
            'Biaya (Rp)' => $a->biaya ? number_format($a->biaya->nominal, 0, ',', '.') : '0',
        ])->toArray();

        ActivityLog::logExport('acara', 'XLS');
        return $this->export->xls(
            'Daftar Acara HIMANIKKA',
            ['No' => 'No', 'Nama Acara' => 'Nama Acara', 'Tanggal' => 'Tanggal', 'Tempat' => 'Tempat',
             'Tipe' => 'Tipe', 'Status' => 'Status', 'Pendaftar' => 'Pendaftar', 'Biaya (Rp)' => 'Biaya (Rp)'],
            $rows, ['Pendaftar', 'Biaya (Rp)'], 'acara-' . now()->format('Ymd')
        );
    }

    // ========================================================================
    //  LAPORAN
    // ========================================================================

    public function laporanCsv()
    {
        $data = Laporan::with(['acara'])->latest()->get()->map(fn($r) => [
            'No' => $r->id,
            'Acara' => $r->acara?->name_acara ?? '-',
            'Jenis' => strtoupper($r->jenis ?? '-'),
            'Nama Laporan' => $r->nama_laporan ?? '-',
            'Tanggal' => $r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') : '-',
        ]);

        ActivityLog::logExport('laporan', 'CSV');
        return $this->streamCsv('laporan-' . now()->format('Ymd'), [
            'No' => 'ID', 'Acara' => 'Acara', 'Jenis' => 'Jenis',
            'Nama Laporan' => 'Nama Laporan', 'Tanggal' => 'Tanggal',
        ], $data, []);
    }

    public function laporanXls()
    {
        $data = Laporan::with(['acara'])->latest()->get();

        $rows = $data->map(fn($r) => [
            'No' => $r->id,
            'Acara' => $r->acara?->name_acara ?? '-',
            'Jenis' => strtoupper($r->jenis ?? '-'),
            'Nama Laporan' => $r->nama_laporan ?? '-',
            'Tanggal' => $r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') : '-',
        ])->toArray();

        ActivityLog::logExport('laporan', 'XLS');
        return $this->export->xls(
            'Daftar Laporan HIMANIKKA',
            ['No' => 'No', 'Acara' => 'Acara', 'Jenis' => 'Jenis',
             'Nama Laporan' => 'Nama Laporan', 'Tanggal' => 'Tanggal'],
            $rows, [], 'laporan-' . now()->format('Ymd')
        );
    }

    public function laporanPdf($id = null)
    {
        if ($id) {
            $laporan = Laporan::with(['acara.user'])->findOrFail($id);
        } else {
            $laporan = Laporan::with(['acara.user'])->latest()->first();
            if (!$laporan) {
                return redirect()->back()->with('error', 'Belum ada laporan untuk diexport.');
            }
        }

        [$view, $data] = $this->export->prepareReportData($laporan);

        ActivityLog::logExport('laporan', 'PDF');
        return $this->export->pdf($view, $data, 'laporan-' . ($id ?? 'all') . '-' . now()->format('Ymd'));
    }

    public function laporanByAcaraPdf($acaraId)
    {
        $laporans = Laporan::where('acara_id', $acaraId)->with(['acara.user'])->get();
        $acara = Acara::find($acaraId);

        if ($laporans->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada laporan untuk acara ini.');
        }

        // Jika hanya satu jenis, pakai template khusus
        if ($laporans->count() === 1) {
            $laporan = $laporans->first();
            [$view, $data] = $this->export->prepareReportData($laporan);

            ActivityLog::logExport('laporan', 'PDF');
            return $this->export->pdf($view, $data, 'laporan-acara-' . $acaraId . '-' . now()->format('Ymd'));
        }

        // Multiple jenis → gunakan template umum
        $jenisList = $laporans->pluck('jenis')->unique()->map(fn($j) => strtoupper($j))->implode(' & ');

        ActivityLog::logExport('laporan', 'PDF');
        return $this->export->pdf('exports.laporan-pdf', [
            'jenisLabel'   => $jenisList ?: 'LAPORAN',
            'acaraName'    => $acara?->name_acara ?? 'Kegiatan HIMANIKKA',
            'acaraTanggal' => $acara?->tanggal,
            'acaraTempat'  => $acara?->tempat,
            'status'       => 'Disetujui',
            'items'        => $laporans->map(fn($l) => [
                'uraian'     => strtoupper($l->jenis) . ' - ' . ($l->acara?->name_acara ?? ''),
                'volume'     => '1',
                'keterangan' => $l->nama_laporan ?? '-',
            ]),
        ], 'laporan-acara-' . $acaraId . '-' . now()->format('Ymd'));
    }

    /**
     * Generate PDF laporan formal untuk acara, simpan ke storage & database laporans.
     * Jenis: proposal, lpj, sk, atau 'lengkap' (gabungan).
     * Menggunakan template formal yang sudah ada (proposal-pdf, lpj-pdf, sk-pdf).
     */
    public function acaraPdf(Acara $acara, $jenis = 'lengkap')
    {
        $acara->load(['user', 'biaya', 'syarat']);

        $keuangan = Keuangan::where('acara_id', $acara->id)->latest()->get();
        $dokumentasi = Dokumentasi::where('acara_id', $acara->id)->get();
        $pendaftarans = Pendaftaran::where('acaras_id', $acara->id)->with('users')->get();
        $jumlahPeserta = $pendaftarans->count();
        $totalBiaya = $keuangan->sum('nominal');

        $jenisMap = [
            'proposal' => 'PROPOSAL KEGIATAN',
            'lpj'      => 'LAPORAN PERTANGGUNGJAWABAN',
            'sk'       => 'SURAT KEPUTUSAN',
            'lengkap'  => 'LAPORAN KEGIATAN',
        ];

        $jenisLabel = $jenisMap[$jenis] ?? 'LAPORAN KEGIATAN';
        $namaLaporan = $jenisLabel . ' - ' . $acara->name_acara;

        // Semua jenis menggunakan template lengkap (cover, kata pengantar, daftar isi, bab 1-5, lampiran)
        $viewMap = [
            'proposal' => 'exports.lengkap-pdf',
            'lpj'      => 'exports.lengkap-pdf',
            'sk'       => 'exports.lengkap-pdf',
            'lengkap'  => 'exports.lengkap-pdf',
        ];
        $view = $viewMap[$jenis] ?? 'exports.laporan-pdf';

        // Data dasar yang dibutuhkan semua template
        $data = [
            'acara'           => $acara,
            'jenis'           => $jenis,
            'jenisLabel'      => $jenisLabel,
            'namaLaporan'     => $namaLaporan,
            'acaraName'       => $acara->name_acara ?? 'Kegiatan HIMANIKKA',
            'acaraTanggal'    => $acara->tanggal,
            'acaraTempat'     => $acara->tempat,
            'acaraTipe'       => $acara->tipe,
            'keteranganAcara' => $acara->keterangan,
            'status'          => 'Disetujui',
            'pj'              => $acara->user->name ?? '-',
            'biaya'           => $acara->biaya?->nominal ?? 0,
            'syarat'          => $acara->syarat?->name_syarat ?? '-',
            'keuangan'        => $keuangan,
            'dokumentasi'     => $dokumentasi,
            'pendaftarans'    => $pendaftarans,
            'jumlahPeserta'   => $jumlahPeserta,
            'totalBiaya'      => $totalBiaya,
            'nomorSurat'      => '---/' . strtoupper($jenis) . '/HIMANIKKA/UPTT/' . now()->format('m/Y'),
            'items'           => collect([
                ['uraian' => $jenisLabel . ' - ' . $acara->name_acara, 'volume' => '1', 'keterangan' => $namaLaporan],
            ]),
        ];

        // Tambah data khusus untuk proposal dan lengkap
        if (in_array($jenis, ['proposal', 'lengkap'])) {
            $user = $acara->user;
            $data['ketuaPelaksana'] = $user->name ?? 'Mahasiswa Teknik Informatika';
            $data['sekretaris'] = 'Mahasiswa Teknik Informatika';
            $data['bendahara'] = 'Mahasiswa Teknik Informatika';
        }

        $filename = $jenis . '-acara-' . $acara->id . '-' . now()->format('Ymd');

        // 1. Simpan PDF ke storage
        $filePath = $this->export->savePdf($view, $data, $filename);

        // 2. Simpan ke database laporans (update jika sudah ada, create jika belum)
        $existing = Laporan::where('acaras_id', $acara->id)->where('jenis', $jenis)->first();
        
        if ($existing) {
            $existing->update([
                'nama_laporan' => $namaLaporan,
                'tanggal' => $acara->tanggal ?? now(),
                'status' => 'approved',
                'file' => $filePath,
            ]);
        } else {
            Laporan::create([
                'acaras_id' => $acara->id,
                'jenis' => $jenis,
                'nama_laporan' => $namaLaporan,
                'tanggal' => $acara->tanggal ?? now(),
                'status' => 'approved',
                'file' => $filePath,
            ]);
        }

        ActivityLog::logExport('acara', 'PDF');

        // 3. Download PDF dari file yang sudah tersimpan
        return response()->download(storage_path('app/public/' . $filePath), $filename . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    // ========================================================================
    //  PENDAFTARAN
    // ========================================================================

    public function pendaftaranCsv(Request $request)
    {
        $query = Pendaftaran::with(['users', 'acaras']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('acara_id')) $query->where('acaras_id', $request->acara_id);

        $data = $query->latest()->get()->map(fn($r) => [
            'No' => $r->id,
            'Nama Pendaftar' => $r->nama_pendaftar ?? $r->users?->name ?? 'Guest',
            'Email' => $r->users?->email ?? '-',
            'No. HP' => $r->NO_HP ?? $r->users?->No_hp ?? $r->users?->phone ?? '-',
            'Acara' => $r->acaras?->name_acara ?? '-',
            'Status' => $r->status ?? '-',
            'Tanggal Daftar' => $r->created_at->format('d/m/Y H:i'),
        ]);

        ActivityLog::logExport('pendaftaran', 'CSV');
        return $this->streamCsv('pendaftaran-' . now()->format('Ymd'), [
            'No' => 'ID', 'Nama Pendaftar' => 'Nama Pendaftar', 'Email' => 'Email',
            'No. HP' => 'No. HP', 'Acara' => 'Acara', 'Status' => 'Status',
            'Tanggal Daftar' => 'Tanggal Daftar',
        ], $data, []);
    }

    public function pendaftaranXls(Request $request)
    {
        $query = Pendaftaran::with(['users', 'acaras']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('acara_id')) $query->where('acaras_id', $request->acara_id);

        $rows = $query->latest()->get()->map(fn($r) => [
            'No' => $r->id,
            'Nama' => $r->nama_pendaftar ?? $r->users?->name ?? 'Guest',
            'Email' => $r->users?->email ?? '-',
            'No. HP' => $r->NO_HP ?? $r->users?->No_hp ?? '-',
            'Acara' => $r->acaras?->name_acara ?? '-',
            'Status' => ucfirst($r->status ?? '-'),
            'Tanggal Daftar' => $r->created_at->format('d/m/Y'),
        ])->toArray();

        ActivityLog::logExport('pendaftaran', 'XLS');
        return $this->export->xls(
            'Daftar Pendaftaran HIMANIKKA',
            ['No' => 'No', 'Nama' => 'Nama', 'Email' => 'Email', 'No. HP' => 'No. HP',
             'Acara' => 'Acara', 'Status' => 'Status', 'Tanggal Daftar' => 'Tanggal Daftar'],
            $rows, [], 'pendaftaran-' . now()->format('Ymd')
        );
    }

    // ========================================================================
    //  USER
    // ========================================================================

    public function userCsv()
    {
        $data = User::with('role')->latest()->get()->map(fn($u) => [
            'No' => $u->id,
            'Nama' => $u->name,
            'NIM' => $u->NIM ?? '-',
            'Email' => $u->email,
            'No. HP' => $u->phone ?? $u->No_hp ?? '-',
            'Role' => $u->role?->name ?? '-',
            'Bergabung' => $u->created_at->format('d/m/Y'),
        ]);

        ActivityLog::logExport('user', 'CSV');
        return $this->streamCsv('users-' . now()->format('Ymd'), [
            'No' => 'ID', 'Nama' => 'Nama', 'NIM' => 'NIM', 'Email' => 'Email',
            'No. HP' => 'No. HP', 'Role' => 'Role', 'Bergabung' => 'Bergabung',
        ], $data, []);
    }

    public function userXls()
    {
        $rows = User::with('role')->latest()->get()->map(fn($u) => [
            'No' => $u->id,
            'Nama' => $u->name,
            'NIM' => $u->NIM ?? '-',
            'Email' => $u->email,
            'Role' => $u->role?->name ?? '-',
            'Bergabung' => $u->created_at->format('d/m/Y'),
        ])->toArray();

        ActivityLog::logExport('user', 'XLS');
        return $this->export->xls(
            'Daftar Users HIMANIKKA',
            ['No' => 'No', 'Nama' => 'Nama', 'NIM' => 'NIM', 'Email' => 'Email',
             'Role' => 'Role', 'Bergabung' => 'Bergabung'],
            $rows, [], 'users-' . now()->format('Ymd')
        );
    }

    // ========================================================================
    //  AUDIT TRAIL
    // ========================================================================

    public function auditTrail(Request $request)
    {
        $query = ActivityLog::with('user')->latest();
        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('module')) $query->module($request->module);
        if ($request->filled('action')) $query->action($request->action);
        if ($request->filled('date_from')) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('created_at', '<=', $request->date_to);

        $logs = $query->paginate(25);
        $modules = ActivityLog::select('module')->distinct()->pluck('module');
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.audit.index', compact('logs', 'modules', 'actions'));
    }
}
