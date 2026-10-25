<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LPJ - {{ $acaraName }}</title>
    <style>
        @page { margin: 3cm 3cm 3cm 4cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.5;
        }

        /* ===== KOP SURAT ===== */
        .kop { text-align: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 3px double #000; }
        .kop .logo { height: 70px; margin-bottom: 4px; }
        .kop h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 4px 0 0; letter-spacing: 2px; }
        .kop h2 { font-size: 11pt; font-weight: normal; margin: 2px 0; }
        .kop .alamat { font-size: 8pt; font-style: italic; color: #333; }

        /* ===== JUDUL ===== */
        .title { text-align: center; margin: 28px 0; }
        .title h3 { font-size: 15pt; font-weight: bold; text-decoration: underline; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 1px; }
        .title p { font-size: 11pt; margin: 3px 0; }

        /* ===== SECTION ===== */
        .section { margin: 18px 0; text-align: justify; }
        .section h4 { font-size: 12pt; font-weight: bold; margin: 16px 0 8px; text-transform: uppercase; text-align: left; }
        .section h5 { font-size: 11pt; font-weight: bold; margin: 12px 0 6px; text-transform: uppercase; }
        .section p { margin: 6px 0; text-indent: 40px; }
        .section .no-indent { text-indent: 0; }
        .section ol, .section ul { margin: 4px 0 4px 30px; padding-left: 10px; }
        .section li { margin: 3px 0; text-align: justify; }

        /* ===== INFO TABLE ===== */
        .info-table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 11pt; }
        .info-table td { padding: 2px 4px; vertical-align: top; }
        .info-table .label { width: 160px; font-weight: bold; }

        /* ===== TABLE DATA ===== */
        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt; }
        table.data th { background: #e2e8f0; border: 1px solid #000; padding: 6px 8px; text-align: center; font-weight: bold; }
        table.data td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }
        table.data .bg-green { background: #dcfce7; }
        table.data .bg-red { background: #fee2e2; }
        table.data .bg-gray { background: #f1f5f9; }
        table.data .bold { font-weight: bold; }
        table.data tfoot td { font-weight: bold; }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 40px; width: 100%; }
        .signature td { width: 50%; vertical-align: top; padding: 0 20px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 30px; }
        .signature .line { display: inline-block; width: 180px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 10pt; }
        .signature .jabatan { font-size: 9pt; margin-top: 2px; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            text-align: center; font-size: 7pt; color: #64748b;
            padding: 4px 0;
            border-top: 1px solid #cbd5e1;
        }
        .footer .pageNumber { font-weight: bold; }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    @include('exports.partials.kop-surat')

    {{-- ===== JUDUL ===== --}}
    <div class="title">
        <h3>LAPORAN PERTANGGUNGJAWABAN</h3>
        <p>{{ $namaLaporan }}</p>
        <p>{{ $acaraName }}</p>
    </div>

    {{-- I. PENDAHULUAN --}}
    <div class="section">
        <h4>I. PENDAHULUAN</h4>
        <p>
            Laporan Pertanggungjawaban (LPJ) ini disusun sebagai bentuk pertanggungjawaban atas pelaksanaan
            kegiatan <strong>{{ $acaraName }}</strong> yang diselenggarakan oleh Himpunan Mahasiswa Teknik
            Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai. LPJ ini memuat laporan pelaksanaan
            kegiatan, rincian anggaran, dokumentasi kegiatan, serta evaluasi dari seluruh rangkaian kegiatan
            yang telah dilaksanakan.
        </p>
    </div>

    {{-- II. NAMA DAN TEMA KEGIATAN --}}
    <div class="section">
        <h4>II. NAMA DAN TEMA KEGIATAN</h4>
        <table class="info-table">
            <tr><td class="label">Nama Kegiatan</td><td>: {{ $acaraName }}</td></tr>
            <tr><td class="label">Tema</td><td>: {{ $acaraTipe ?? 'Kegiatan Mahasiswa Teknik Informatika' }}</td></tr>
            <tr><td class="label">Jenis Laporan</td><td>: {{ $jenisLabel }}</td></tr>
        </table>
    </div>

    {{-- III. PELAKSANAAN KEGIATAN --}}
    <div class="section">
        <h4>III. PELAKSANAAN KEGIATAN</h4>
        <p>Kegiatan <strong>{{ $acaraName }}</strong> telah dilaksanakan pada:</p>
        <table class="info-table">
            <tr><td class="label">Hari/Tanggal</td><td>:
                @if($acaraTanggal)
                    {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}
                @else
                    -
                @endif
            </td></tr>
            <tr><td class="label">Tempat</td><td>: {{ $acaraTempat ?? '-' }}</td></tr>
        </table>
    </div>

    {{-- IV. HASIL KEGIATAN --}}
    <div class="section">
        <h4>IV. HASIL KEGIATAN</h4>
        <p>
            Kegiatan <strong>{{ $acaraName }}</strong> telah berjalan dengan lancar dan sukses.
            Kegiatan ini diikuti oleh peserta dari kalangan mahasiswa Teknik Informatika
            Universitas Pahlawan Tuanku Tambusai.
        </p>

        @if(isset($jumlahPeserta))
        <table class="info-table">
            <tr><td class="label">Jumlah Peserta</td><td>: {{ $jumlahPeserta }} orang</td></tr>
        </table>
        @endif

        <p>
            Seluruh rangkaian kegiatan dapat terlaksana sesuai dengan rencana yang telah ditetapkan
            dalam proposal kegiatan. Kegiatan berjalan dengan tertib, lancar, dan kondusif.
        </p>
    </div>

    {{-- V. RINCIAN ANGGARAN --}}
    <div class="section">
        <h4>V. RINCIAN ANGGARAN</h4>
        <p>Berikut adalah rincian anggaran pemasukan dan pengeluaran kegiatan:</p>

        @if(isset($keuangan) && count($keuangan) > 0)
            @php
                $pemasukan = $keuangan->where('jenis', 'pemasukan');
                $pengeluaran = $keuangan->where('jenis', 'pengeluaran');
                $totalPemasukan = $pemasukan->sum('nominal');
                $totalPengeluaran = $pengeluaran->sum('nominal');
            @endphp

            <h5>a. Pemasukan</h5>
            <table class="data">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Uraian</th>
                        <th>Kategori</th>
                        <th width="130">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasukan as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $row->keterangan ?? '-' }}</td>
                        <td>{{ $row->kategori ?? '-' }}</td>
                        <td class="text-right">{{ number_format($row->nominal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data pemasukan</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bold bg-green">
                        <td colspan="3" class="text-right">Total Pemasukan</td>
                        <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <h5>b. Pengeluaran</h5>
            <table class="data">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Uraian</th>
                        <th>Kategori</th>
                        <th width="130">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluaran as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $row->keterangan ?? '-' }}</td>
                        <td>{{ $row->kategori ?? '-' }}</td>
                        <td class="text-right">{{ number_format($row->nominal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data pengeluaran</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bold bg-red">
                        <td colspan="3" class="text-right">Total Pengeluaran</td>
                        <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <h5>c. Rekapitulasi Anggaran</h5>
            <table class="data">
                <tr>
                    <td colspan="3" style="border: none; text-align: right; padding: 8px; font-weight: bold;">Total Pemasukan</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; text-align: right; padding: 8px; font-weight: bold;">Total Pengeluaran</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
                <tr class="bold bg-gray">
                    <td colspan="3" style="text-align: right; padding: 8px;">Saldo Akhir</td>
                    <td style="text-align: right;">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
            </table>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Uraian</th>
                        <th width="130">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item['uraian'] ?? $item }}</td>
                        <td class="text-right">-</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">Tidak ada data anggaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    {{-- VI. DOKUMENTASI --}}
    <div class="section">
        <h4>VI. DOKUMENTASI KEGIATAN</h4>
        <p>
            Dokumentasi kegiatan <strong>{{ $acaraName }}</strong> dapat dilihat pada lampiran dokumen
            fotografi yang dilampirkan bersama laporan ini. Dokumentasi mencakup foto-foto selama persiapan,
            pelaksanaan, dan penutupan kegiatan.
        </p>
        @if(isset($dokumentasi) && count($dokumentasi) > 0)
        <p style="text-indent: 0;">Dokumentasi yang tersedia:</p>
        <ol>
            @foreach($dokumentasi as $dok)
            <li>{{ $dok->name_dokumentasi ?? $dok['name_dokumentasi'] ?? 'Dokumentasi' }}</li>
            @endforeach
        </ol>
        @endif
    </div>

    {{-- VII. EVALUASI --}}
    <div class="section">
        <h4>VII. EVALUASI</h4>
        <p>
            Secara keseluruhan, kegiatan <strong>{{ $acaraName }}</strong> telah berjalan dengan baik
            dan sesuai dengan rencana yang telah ditetapkan. Namun demikian, terdapat beberapa hal yang
            perlu menjadi perhatian untuk kegiatan selanjutnya, antara lain:
        </p>
        <ol>
            <li>Koordinasi antar panitia perlu lebih ditingkatkan.</li>
            <li>Persiapan perlengkapan sebaiknya dilakukan lebih awal.</li>
            <li>Sosialisasi kegiatan kepada peserta perlu dilakukan secara lebih intensif.</li>
        </ol>
    </div>

    {{-- VIII. PENUTUP --}}
    <div class="section">
        <h4>VIII. PENUTUP</h4>
        <p>
            Demikian Laporan Pertanggungjawaban (LPJ) ini kami buat dengan sebenar-benarnya
            sebagai bentuk akuntabilitas dan transparansi pengurus Himpunan Mahasiswa Teknik
            Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai dalam melaksanakan
            kegiatan. Besar harapan kami agar laporan ini dapat diterima dan menjadi bahan
            evaluasi untuk kegiatan-kegiatan selanjutnya. Atas perhatian dan kerjasamanya,
            kami ucapkan terima kasih.
        </p>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'lpj'])

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
