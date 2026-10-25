<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PROPOSAL KEGIATAN - {{ $acaraName }}</title>
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
        .title .nomor { font-size: 11pt; margin: 4px 0; }
        .title .lampiran { font-size: 10pt; margin: 2px 0; }
        .title .perihal { font-size: 11pt; font-weight: bold; margin: 4px 0; text-transform: uppercase; }

        /* ===== ALAMAT TUJUAN ===== */
        .alamat-surat { margin: 16px 0; font-size: 11pt; }
        .alamat-surat td { padding: 2px 4px; vertical-align: top; }
        .alamat-surat .label { width: 80px; }

        /* ===== SECTION ===== */
        .section { margin: 18px 0; text-align: justify; }
        .section h4 { font-size: 12pt; font-weight: bold; margin: 16px 0 8px; text-transform: uppercase; text-align: left; }
        .section h5 { font-size: 11pt; font-weight: bold; margin: 12px 0 6px; text-transform: uppercase; }
        .section p { margin: 6px 0; text-indent: 40px; }
        .section .no-indent { text-indent: 0; }
        .section ol, .section ul { margin: 4px 0 4px 30px; padding-left: 10px; }
        .section li { margin: 3px 0; text-align: justify; }

        /* ===== TABLE DATA ===== */
        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt; }
        table.data th { background: #e2e8f0; border: 1px solid #000; padding: 6px 8px; text-align: center; font-weight: bold; }
        table.data td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }
        table.data tfoot td { font-weight: bold; background: #f1f5f9; }

        /* ===== INFO TABLE (non-border) ===== */
        .info-table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 11pt; }
        .info-table td { padding: 2px 4px; vertical-align: top; }
        .info-table .label { width: 160px; font-weight: bold; }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 40px; width: 100%; }
        .signature td { vertical-align: top; padding: 0 10px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 30px; }
        .signature .line { display: inline-block; width: 180px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 10pt; }
        .signature .jabatan { font-size: 9pt; margin-top: 2px; }
        .signature-3col td { width: 33%; }

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

    {{-- ===== JUDUL / HEADER ===== --}}
    <div class="title">
        <h3>PROPOSAL KEGIATAN</h3>
        <p class="nomor">Nomor: {{ $nomorSurat ?? '---/PK/HIMANIKKA/UPTT/' . now()->format('m/Y') }}</p>
        <p class="lampiran">Lampiran: 1 (satu) berkas</p>
        <p class="perihal">Perihal: Permohonan Persetujuan Kegiatan</p>
    </div>

    {{-- ===== ALAMAT TUJUAN ===== --}}
    <table class="alamat-surat">
        <tr>
            <td class="label">Kepada</td>
            <td>: Yth. Pembina HIMANIKKA</td>
        </tr>
        <tr>
            <td></td>
            <td>: Universitas Pahlawan Tuanku Tambusai</td>
        </tr>
        <tr>
            <td></td>
            <td>: Di Tempat</td>
        </tr>
    </table>

    {{-- ===== PEMBUKA ===== --}}
    <div class="section">
        <p>Assalamu'alaikum Wr. Wb.</p>
        <p>Dengan hormat,</p>
        <p>
            Sehubungan dengan akan diselenggarakannya kegiatan <strong>{{ $acaraName }}</strong> oleh
            Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai,
            dengan ini kami mengajukan proposal kegiatan sebagai berikut:
        </p>
    </div>

    {{-- I. PENDAHULUAN / LATAR BELAKANG --}}
    <div class="section">
        <h4>I. PENDAHULUAN</h4>
        @if($keteranganAcara)
            <p>{{ $keteranganAcara }}</p>
        @else
            <p>
                Dalam rangka mengembangkan potensi dan kreativitas mahasiswa Teknik Informatika, serta untuk
                meningkatkan kualitas sumber daya mahasiswa di lingkungan Universitas Pahlawan Tuanku Tambusai,
                maka Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) bermaksud menyelenggarakan kegiatan
                <strong>{{ $acaraName }}</strong>.
            </p>
        @endif
    </div>

    {{-- II. NAMA KEGIATAN --}}
    <div class="section">
        <h4>II. NAMA KEGIATAN</h4>
        <p style="text-indent: 0; font-weight: bold; text-align: center;">{{ $acaraName }}</p>
    </div>

    {{-- III. TEMA --}}
    <div class="section">
        <h4>III. TEMA</h4>
        <p style="text-indent: 0; text-align: center; font-style: italic; font-weight: bold;">
            @if($acaraTipe)
                "{{ $acaraTipe }}"
            @else
                "Meningkatkan Kreativitas dan Inovasi Mahasiswa Teknik Informatika dalam Rangka Membangun Generasi Emas"
            @endif
        </p>
    </div>

    {{-- IV. TUJUAN KEGIATAN --}}
    <div class="section">
        <h4>IV. TUJUAN KEGIATAN</h4>
        <p>Tujuan dari pelaksanaan kegiatan ini adalah sebagai berikut:</p>
        <ol>
            <li>Meningkatkan wawasan dan pengetahuan mahasiswa di bidang Teknik Informatika.</li>
            <li>Mengembangkan bakat dan minat mahasiswa dalam kegiatan non-akademik.</li>
            <li>Mempererat tali silaturahmi antar mahasiswa Teknik Informatika.</li>
            <li>Meningkatkan kreativitas dan inovasi mahasiswa dalam berkarya.</li>
        </ol>
    </div>

    {{-- V. SASARAN --}}
    <div class="section">
        <h4>V. SASARAN KEGIATAN</h4>
        <p>Sasaran kegiatan ini adalah seluruh mahasiswa aktif Program Studi Teknik Informatika Universitas Pahlawan Tuanku Tambusai.</p>
    </div>

    {{-- VI. WAKTU DAN TEMPAT --}}
    <div class="section">
        <h4>VI. WAKTU DAN TEMPAT PELAKSANAAN</h4>
        <table class="info-table">
            <tr>
                <td class="label">Hari/Tanggal</td>
                <td>:
                    @if($acaraTanggal)
                        {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td>: {{ $acaraTempat ?? 'Lingkungan Kampus Universitas Pahlawan Tuanku Tambusai' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>: {{ now()->format('H:i') }} WIB - Selesai</td>
            </tr>
        </table>
    </div>

    {{-- VII. ANGGARAN BIAYA --}}
    <div class="section">
        <h4>VII. ANGGARAN BIAYA</h4>
        <p>Rencana anggaran biaya kegiatan ini adalah sebagai berikut:</p>

        @if(isset($keuangan) && count($keuangan) > 0)
            @php
                $totalBiaya = $keuangan->sum('nominal');
            @endphp
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
                    @forelse($keuangan as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $row->keterangan ?? $row['keterangan'] ?? '-' }}</td>
                        <td>{{ $row->kategori ?? $row['kategori'] ?? '-' }}</td>
                        <td class="text-right">{{ number_format($row->nominal ?? $row['nominal'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">-</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Total Anggaran</td>
                        <td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Uraian</th>
                        <th>Volume</th>
                        <th width="130">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item['uraian'] ?? $item }}</td>
                        <td class="text-center">{{ $item['volume'] ?? '1' }}</td>
                        <td class="text-right">{{ $item['biaya'] ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">-</td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    {{-- VIII. SUSUNAN PANITIA --}}
    <div class="section">
        <h4>VIII. SUSUNAN PANITIA</h4>
        <p>Susunan panitia kegiatan <strong>{{ $acaraName }}</strong> adalah sebagai berikut:</p>
        <table class="data">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Jabatan</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="text-center">1</td><td>Pelindung</td><td>Rektor Universitas Pahlawan Tuanku Tambusai</td></tr>
                <tr><td class="text-center">2</td><td>Penanggung Jawab</td><td>Ketua HIMANIKKA</td></tr>
                <tr><td class="text-center">3</td><td>Ketua Pelaksana</td><td>{{ $ketuaPelaksana ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">4</td><td>Sekretaris</td><td>{{ $sekretaris ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">5</td><td>Bendahara</td><td>{{ $bendahara ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">6</td><td>Seksi Acara</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">7</td><td>Seksi Perlengkapan</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">8</td><td>Seksi Konsumsi</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">9</td><td>Seksi Dokumentasi</td><td>Mahasiswa Teknik Informatika</td></tr>
            </tbody>
        </table>
    </div>

    {{-- IX. PENUTUP --}}
    <div class="section">
        <h4>IX. PENUTUP</h4>
        <p>
            Demikian proposal ini kami buat dengan harapan dapat diterima dan mendapat dukungan
            dari semua pihak. Besar harapan kami atas partisipasi dan kerjasama dari Bapak/Ibu
            Pembina HIMANIKKA serta seluruh pihak terkait. Atas perhatian dan kerjasamanya,
            kami ucapkan terima kasih.
        </p>
        <p style="margin-top: 12px;">Wassalamu'alaikum Wr. Wb.</p>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'panitia'])

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
