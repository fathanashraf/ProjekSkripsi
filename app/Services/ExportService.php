<?php

namespace App\Services;

use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ExportService
{
    /**
     * Pilih template PDF sesuai jenis laporan dan muat data tambahan.
     * Return [viewName, dataArray].
     */
    public function prepareReportData(\App\Models\Laporan $laporan): array
    {
        $acara = $laporan?->acara;
        $jenis = $laporan->jenis;

        $jenisMap = [
            'proposal' => 'PROPOSAL KEGIATAN',
            'lpj'      => 'LAPORAN PERTANGGUNGJAWABAN',
            'sk'       => 'SURAT KEPUTUSAN',
            'lengkap'  => 'LAPORAN KEGIATAN',
        ];

        $viewMap = [
            'proposal' => 'exports.lengkap-pdf',
            'lpj'      => 'exports.lengkap-pdf',
            'sk'       => 'exports.lengkap-pdf',
            'lengkap'  => 'exports.lengkap-pdf',
        ];
        // Semua jenis menggunakan template lengkap yang mencakup cover, kata pengantar,
        // daftar isi, bab 1-5, dan lampiran.

        $view = $viewMap[$jenis] ?? 'exports.laporan-pdf';
        $jenisLabel = $jenisMap[$jenis] ?? strtoupper($jenis ?? 'LAPORAN');

        $data = [
            'jenisLabel'       => $jenisLabel,
            'acaraName'        => $acara?->name_acara ?? 'Kegiatan HIMANIKKA',
            'acaraTanggal'     => $acara?->tanggal,
            'acaraTempat'      => $acara?->tempat,
            'acaraTipe'        => $acara?->tipe,
            'keteranganAcara'  => $acara?->keterangan,
            'namaLaporan'      => $laporan->nama_laporan ?? $jenisLabel,
            'status'           => $laporan->status ?? 'Disetujui',
            'nomorSurat'       => $laporan->nomor_surat ?? null,
            'items'            => collect([
                ['uraian' => $jenisLabel . ' - ' . ($acara?->name_acara ?? ''), 'volume' => '1'],
            ]),
        ];

        // Semua jenis pakai data yang sama untuk template lengkap
        if ($acara) {
            $data['keuangan'] = \App\Models\Keuangan::where('acara_id', $acara->id)->latest()->get();
            $data['dokumentasi'] = \App\Models\Dokumentasi::where('acara_id', $acara->id)->get();
            $data['pendaftarans'] = \App\Models\Pendaftaran::where('acaras_id', $acara->id)->with('users')->get();
            $data['jumlahPeserta'] = $data['pendaftarans']->count();
            $data['totalBiaya'] = $data['keuangan']->sum('nominal');
            $data['ketuaPelaksana'] = $acara->user?->name ?? 'Mahasiswa Teknik Informatika';
            $data['sekretaris'] = 'Mahasiswa Teknik Informatika';
            $data['bendahara'] = 'Mahasiswa Teknik Informatika';
            $data['pj'] = $acara->user?->name ?? '-';
            $data['biaya'] = $acara->biaya?->nominal ?? 0;
            $data['syarat'] = $acara->syarat?->name_syarat ?? '-';
            $data['acaraTipe'] = $acara->tipe;
            $data['keteranganAcara'] = $acara->keterangan;
        }

        return [$view, $data];
    }

    /**
     * Generate PDF with formal kop surat style.
     */
    public function pdf(string $view, array $data, string $filename): \Illuminate\Http\Response
    {
        $dompdf = $this->loadPdf($view, $data);
        return $dompdf->download($filename . '.pdf');
    }

    /**
     * Generate PDF dan simpan ke storage.
     * Return path relatif terhadap storage.
     */
    public function savePdf(string $view, array $data, string $filename, string $folder = 'laporan'): string
    {
        $pdf = $this->loadPdf($view, $data);
        $pdfContent = $pdf->output();

        $relativePath = $folder . '/' . $filename . '.pdf';
        Storage::disk('public')->put($relativePath, $pdfContent);

        return $relativePath;
    }

    /**
     * Load view dan setup DOMPDF.
     * Secara otomatis menyertakan data Profil organisasi ke semua view PDF.
     */
    private function loadPdf(string $view, array $data)
    {
        // Muat data Profil organisasi untuk kop surat
        $profil = Profil::first();
        $data['profil'] = $profil;

        // Konversi logo ke base64 agar DOMPDF bisa render di Windows
        $data['logo_himanikka_base64'] = $this->imageToBase64($profil?->logo, 'assets/logohima-.png');
        $data['logo_univ_base64'] = $this->imageToBase64($profil?->logo_univ, 'assets/logo-univ.png');

        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'isPhpEnabled' => true,
        ]);

        return $pdf;
    }

    /**
     * Konversi file gambar ke base64 data URI.
     * Cek storage dulu, lalu fallback ke assets.
     */
    private function imageToBase64(?string $storagePath, string $fallbackAsset): ?string
    {
        $paths = [];

        if ($storagePath) {
            $paths[] = public_path('storage/' . $storagePath);
        }
        $paths[] = public_path($fallbackAsset);

        foreach ($paths as $path) {
            if ($path && file_exists($path)) {
                $mime = mime_content_type($path) ?: 'image/png';
                $data = file_get_contents($path);
                if ($data !== false) {
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }
        }

        return null;
    }

    /**
     * Generate Excel (.xls) using HTML table approach with formal letter format.
     * Excel can open HTML tables with full formatting including kop surat.
     */
    public function xls(string $title, array $headers, array $rows, array $numericCols = [], string $filename = 'export'): \Illuminate\Http\Response
    {
        $html = $this->buildFormalExcel($title, $headers, $rows, $numericCols);

        return Response::make($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.xls"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    /**
     * Build formal letter format Excel with kop surat HIMANIKKA.
     */
    private function buildFormalExcel(string $title, array $headers, array $rows, array $numericCols): string
    {
        // Ambil data Profil untuk kop surat
        $profil = Profil::first();
        $instansi = $profil->name_instansi ?? 'Himpunan Mahasiswa Teknik Informatika';
        $universitas = $profil->alamat ?? 'Universitas Pahlawan Tuanku Tambusai';

        // Build header cells
        $headerCells = '';
        foreach ($headers as $key => $label) {
            $headerCells .= '<th style="background-color: #1e40af; color: #ffffff; font-weight: bold; padding: 10px 12px; border: 1px solid #1e3a8a; font-size: 10pt; font-family: Calibri, Arial, sans-serif; text-align: center;">' . $label . '</th>';
        }

        // Build body rows
        $bodyRows = '';
        foreach ($rows as $row) {
            $bodyRows .= '<tr>';
            foreach ($headers as $key => $label) {
                $value = $row[$key] ?? '';
                $isNumeric = in_array($key, $numericCols);
                $align = $isNumeric ? 'right' : 'left';
                $numFmt = $isNumeric ? 'mso-number-format:\"\#\,\#\#0\"' : '';
                $bodyRows .= '<td style="padding: 6px 10px; border: 1px solid #94a3b8; font-size: 10pt; font-family: Calibri, Arial, sans-serif; vertical-align: middle; text-align: ' . $align . '; ' . $numFmt . '">' . $value . '</td>';
            }
            $bodyRows .= '</tr>';
        }

        // Total row
        $totalRow = '';
        if (!empty($numericCols)) {
            $totalRow .= '<tr>';
            $firstKey = array_key_first($headers);
            foreach ($headers as $key => $label) {
                if (in_array($key, $numericCols)) {
                    $total = 0;
                    foreach ($rows as $row) {
                        $val = $row[$key] ?? 0;
                        $val = str_replace(['.', ','], ['', '.'], (string) $val);
                        $total += (float) $val;
                    }
                    $totalRow .= '<td style="padding: 8px 10px; border: 1px solid #94a3b8; font-size: 10pt; font-family: Calibri, Arial, sans-serif; text-align: right; font-weight: bold; mso-number-format:\"\#\,\#\#0\"">' . number_format($total, 0, ',', '.') . '</td>';
                } else {
                    $labelText = ($key === $firstKey) ? 'TOTAL' : '';
                    $totalRow .= '<td style="padding: 8px 10px; border: 1px solid #94a3b8; font-size: 10pt; font-family: Calibri, Arial, sans-serif; font-weight: bold;">' . $labelText . '</td>';
                }
            }
            $totalRow .= '</tr>';
        }

        $footerDate = 'Dicetak pada: ' . now()->translatedFormat('l, d F Y H:i');

        // Build full HTML document with kop surat
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$title}</title>
    <style>
        @page { margin: 1.5cm 2cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; }
        .kop { text-align: center; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 3px double #000; }
        .kop h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 4px 0 0; letter-spacing: 2px; font-family: 'Times New Roman', serif; }
        .kop h2 { font-size: 11pt; font-weight: normal; margin: 2px 0; font-family: 'Times New Roman', serif; }
        .kop .alamat { font-size: 8pt; font-style: italic; margin: 2px 0; color: #333; }
        .judul { text-align: center; margin: 20px 0; }
        .judul h3 { font-size: 14pt; font-weight: bold; text-decoration: underline; margin: 0 0 4px; text-transform: uppercase; }
        .judul p { font-size: 11pt; margin: 0; }
        .pembukaan { font-size: 11pt; text-align: justify; margin: 12px 0; text-indent: 40px; }
        table { border-collapse: collapse; width: 100%; margin: 12px 0; }
        .penutup { font-size: 11pt; text-align: justify; margin: 12px 0; text-indent: 40px; }
        .ttd { margin-top: 30px; width: 100%; }
        .ttd td { width: 50%; vertical-align: top; padding: 0 20px; font-size: 11pt; }
        .ttd .right { text-align: center; }
        .ttd .place-date { margin-bottom: 30px; }
        .ttd .nama { font-weight: bold; margin-top: 60px; }
        .ttd .jabatan { font-size: 10pt; }
        .footer { margin-top: 20px; font-size: 8pt; text-align: center; color: #666; }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop">
        <h1>{$instansi}</h1>
        <h2>{$universitas}</h2>
        <p class="alamat">
            Jalan Tuanku Tambusai No. 23, Bangkinang, Kab. Kampar, Riau 28412<br>
            Email: himanikka@uptt.ac.id &bull; Website: himanikka.uptt.ac.id
        </p>
    </div>

    <!-- Judul -->
    <div class="judul">
        <h3>{$title}</h3>
        <p>{$instansi} &mdash; {$universitas}</p>
    </div>

    <!-- Pembukaan -->
    <div class="pembukaan">
        <p>Yang bertanda tangan di bawah ini, Ketua {$instansi} {$universitas}, dengan ini menerangkan data sebagai berikut:</p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>{$headerCells}</tr>
        </thead>
        <tbody>
            {$bodyRows}
            {$totalRow}
        </tbody>
    </table>

    <!-- Penutup -->
    <div class="penutup">
        <p>Demikian data ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan -->
    <table class="ttd">
        <tr>
            <td>
                <div class="place-date">
                    Mengetahui,<br>
                    Pembina {$instansi}
                </div>
                <div class="nama">_________________</div>
                <div class="jabatan">Pembina {$instansi}</div>
            </td>
            <td class="right">
                <div class="place-date">
                    Bangkinang, {$footerDate}
                </div>
                <div class="nama">_________________</div>
                <div class="jabatan">Ketua {$instansi}</div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Dokumen ini digenerate otomatis oleh Sistem Informasi {$instansi} UPTT &mdash; himanikka.free.je
    </div>
</body>
</html>
HTML;
    }
}
