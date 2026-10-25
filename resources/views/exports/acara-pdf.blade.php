<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $jenisLabel }} - {{ $acaraName }}</title>
    <style>
        @page { margin: 3cm 3cm 3cm 4cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; line-height: 1.5; }
        .kop { text-align: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 3px double #000; }
        .kop .logo { height: 70px; margin-bottom: 4px; }
        .kop h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 4px 0 0; letter-spacing: 2px; }
        .kop h2 { font-size: 11pt; font-weight: normal; margin: 2px 0; }
        .kop .alamat { font-size: 8pt; font-style: italic; color: #333; }
        .title { text-align: center; margin: 28px 0; }
        .title h3 { font-size: 15pt; font-weight: bold; text-decoration: underline; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 1px; }
        .title p { font-size: 11pt; margin: 3px 0; }
        .section { margin: 18px 0; text-align: justify; }
        .section h4 { font-size: 12pt; font-weight: bold; margin: 16px 0 8px; text-transform: uppercase; text-align: left; }
        .section h5 { font-size: 11pt; font-weight: bold; margin: 12px 0 6px; text-transform: uppercase; }
        .section p { margin: 6px 0; text-indent: 40px; }
        .section .no-indent { text-indent: 0; }
        .section ol, .section ul { margin: 4px 0 4px 30px; padding-left: 10px; }
        .section li { margin: 3px 0; text-align: justify; }
        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt; }
        table.data th { background: #e2e8f0; border: 1px solid #000; padding: 6px 8px; text-align: center; font-weight: bold; }
        table.data td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }
        table.data tfoot td { font-weight: bold; background: #f1f5f9; }
        .info-table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 11pt; }
        .info-table td { padding: 2px 4px; vertical-align: top; }
        .info-table .label { width: 160px; font-weight: bold; }
        .signature { margin-top: 40px; width: 100%; }
        .signature td { vertical-align: top; padding: 0 10px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 30px; }
        .signature .line { display: inline-block; width: 180px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 10pt; }
        .signature .jabatan { font-size: 9pt; margin-top: 2px; }
        .signature-3col td { width: 33%; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 7pt; color: #64748b; padding: 4px 0; border-top: 1px solid #cbd5e1; }
        .footer .pageNumber { font-weight: bold; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    @include('exports.partials.kop-surat')

    {{-- JUDUL --}}
    <div class="title">
        <h3>{{ $jenisLabel }}</h3>
        <p>{{ $acaraName }}</p>
    </div>

    {{-- INFO ACARA --}}
    <table class="info-table">
        <tr><td class="label">Nama Acara</td><td>: {{ $acaraName }}</td></tr>
        @if($acaraTanggal)<tr><td class="label">Tanggal</td><td>: {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}</td></tr>@endif
        @if($acaraTempat)<tr><td class="label">Tempat</td><td>: {{ $acaraTempat }}</td></tr>@endif
        <tr><td class="label">Tipe Acara</td><td>: {{ ucfirst($acaraTipe ?? '-') }}</td></tr>
        <tr><td class="label">Penanggung Jawab</td><td>: {{ $pj ?? '-' }}</td></tr>
        <tr><td class="label">Total Peserta</td><td>: {{ $jumlahPeserta }} orang</td></tr>
        <tr><td class="label">Total Anggaran</td><td>: Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td></tr>
    </table>

    {{-- ISI LAPORAN BERDASARKAN JENIS --}}
    @if($jenis === 'proposal')
        {{-- PROPOSAL --}}
        <div class="section">
            <h4>I. PENDAHULUAN</h4>
            <p>{{ $keteranganAcara ?? 'Dalam rangka mengembangkan potensi dan kreativitas mahasiswa Teknik Informatika, serta untuk meningkatkan kualitas sumber daya mahasiswa di lingkungan Universitas Pahlawan Tuanku Tambusai, maka Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) bermaksud menyelenggarakan kegiatan ini.' }}</p>
        </div>
        <div class="section">
            <h4>II. NAMA KEGIATAN</h4>
            <p class="no-indent" style="font-weight: bold; text-align: center;">{{ $acaraName }}</p>
        </div>
        <div class="section">
            <h4>III. TUJUAN KEGIATAN</h4>
            <ol>
                <li>Meningkatkan wawasan dan pengetahuan mahasiswa di bidang Teknik Informatika.</li>
                <li>Mengembangkan bakat dan minat mahasiswa dalam kegiatan non-akademik.</li>
                <li>Mempererat tali silaturahmi antar mahasiswa Teknik Informatika.</li>
                <li>Meningkatkan kreativitas dan inovasi mahasiswa dalam berkarya.</li>
            </ol>
        </div>
        <div class="section">
            <h4>IV. WAKTU DAN TEMPAT</h4>
            <table class="info-table">
                <tr><td class="label">Hari/Tanggal</td><td>: {{ $acaraTanggal ? \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') : '-' }}</td></tr>
                <tr><td class="label">Tempat</td><td>: {{ $acaraTempat ?? 'Lingkungan Kampus UPTT' }}</td></tr>
            </table>
        </div>
        <div class="section">
            <h4>V. ANGGARAN BIAYA</h4>
            @if(count($keuangan) > 0)
                <table class="data">
                    <thead><tr><th width="30">No</th><th>Uraian</th><th>Kategori</th><th width="130">Jumlah (Rp)</th></tr></thead>
                    <tbody>
                        @foreach($keuangan as $i => $row)
                        <tr><td class="text-center">{{ $i + 1 }}</td><td>{{ $row->keterangan ?? '-' }}</td><td>{{ $row->kategori ?? '-' }}</td><td class="text-right">{{ number_format($row->nominal ?? 0, 0, ',', '.') }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot><tr><td colspan="3" class="text-right">Total</td><td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td></tr></tfoot>
                </table>
            @else
                <p>Biaya kegiatan ini bersumber dari kas HIMANIKKA dan partisipasi peserta.</p>
            @endif
        </div>

    @elseif($jenis === 'lpj')
        {{-- LPJ --}}
        <div class="section">
            <h4>I. PENDAHULUAN</h4>
            <p>Laporan Pertanggungjawaban ini dibuat sebagai bentuk akuntabilitas HIMANIKKA atas terselenggaranya kegiatan <strong>{{ $acaraName }}</strong>.</p>
        </div>
        <div class="section">
            <h4>II. PELAKSANAAN KEGIATAN</h4>
            <table class="info-table">
                <tr><td class="label">Nama Kegiatan</td><td>: {{ $acaraName }}</td></tr>
                <tr><td class="label">Tanggal</td><td>: {{ $acaraTanggal ? \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') : '-' }}</td></tr>
                <tr><td class="label">Tempat</td><td>: {{ $acaraTempat ?? '-' }}</td></tr>
                <tr><td class="label">Jumlah Peserta</td><td>: {{ $jumlahPeserta }} orang</td></tr>
            </table>
        </div>
        <div class="section">
            <h4>III. REALISASI ANGGARAN</h4>
            @if(count($keuangan) > 0)
                <table class="data">
                    <thead><tr><th width="30">No</th><th>Uraian</th><th>Kategori</th><th width="130">Jumlah (Rp)</th></tr></thead>
                    <tbody>
                        @foreach($keuangan as $i => $row)
                        <tr><td class="text-center">{{ $i + 1 }}</td><td>{{ $row->keterangan ?? '-' }}</td><td>{{ $row->kategori ?? '-' }}</td><td class="text-right">{{ number_format($row->nominal ?? 0, 0, ',', '.') }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot><tr><td colspan="3" class="text-right">Total Realisasi</td><td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td></tr></tfoot>
                </table>
            @else
                <p>Tidak ada data keuangan untuk kegiatan ini.</p>
            @endif
        </div>
        <div class="section">
            <h4>IV. DOKUMENTASI</h4>
            @if(count($dokumentasi) > 0)
                <table class="data">
                    <thead><tr><th width="30">No</th><th>Nama Dokumentasi</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @foreach($dokumentasi as $i => $dok)
                        <tr><td class="text-center">{{ $i + 1 }}</td><td>{{ $dok->name_dokumentasi ?? '-' }}</td><td>{{ $dok->keterangan ?? '-' }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Dokumentasi kegiatan menyusul.</p>
            @endif
        </div>
        <div class="section">
            <h4>V. PENUTUP</h4>
            <p>Demikian laporan pertanggungjawaban ini dibuat dengan sebenar-benarnya. Semoga kegiatan ini dapat memberikan manfaat bagi seluruh pihak.</p>
        </div>

    @elseif($jenis === 'sk')
        {{-- SK --}}
        <div class="section">
            <p class="no-indent">Dengan ini menetapkan Surat Keputusan mengenai kegiatan <strong>{{ $acaraName }}</strong> sebagai berikut:</p>
        </div>
        <div class="section">
            <h4>PERTAMA</h4>
            <p>Kegiatan <strong>{{ $acaraName }}</strong> resmi ditetapkan dan diselenggarakan oleh HIMANIKKA Universitas Pahlawan Tuanku Tambusai.</p>
        </div>
        <div class="section">
            <h4>KEDUA</h4>
            <table class="info-table">
                <tr><td class="label">Kegiatan</td><td>: {{ $acaraName }}</td></tr>
                <tr><td class="label">Tanggal</td><td>: {{ $acaraTanggal ? \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') : '-' }}</td></tr>
                @if($acaraTempat)<tr><td class="label">Tempat</td><td>: {{ $acaraTempat }}</td></tr>@endif
                <tr><td class="label">Penanggung Jawab</td><td>: {{ $pj ?? '-' }}</td></tr>
            </table>
        </div>
        <div class="section">
            <h4>KETIGA</h4>
            <p>Surat Keputusan ini berlaku sejak tanggal ditetapkan dan berakhir setelah seluruh rangkaian kegiatan selesai dilaksanakan.</p>
        </div>

    @else
        {{-- LENGKAP / GENERAL --}}
        <div class="section">
            <h4>A. INFORMASI KEGIATAN</h4>
            <table class="info-table">
                <tr><td class="label">Nama Acara</td><td>: {{ $acaraName }}</td></tr>
                @if($acaraTanggal)<tr><td class="label">Tanggal</td><td>: {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}</td></tr>@endif
                @if($acaraTempat)<tr><td class="label">Tempat</td><td>: {{ $acaraTempat }}</td></tr>@endif
                <tr><td class="label">Tipe</td><td>: {{ ucfirst($acaraTipe ?? '-') }}</td></tr>
                <tr><td class="label">PJ</td><td>: {{ $pj ?? '-' }}</td></tr>
                <tr><td class="label">Peserta</td><td>: {{ $jumlahPeserta }} orang</td></tr>
            </table>
        </div>
        <div class="section">
            <h4>B. KETERANGAN</h4>
            <p>{{ $keteranganAcara ?? 'Kegiatan ini diselenggarakan oleh HIMANIKKA Universitas Pahlawan Tuanku Tambusai.' }}</p>
        </div>
        <div class="section">
            <h4>C. PENDAPATAN & ANGGARAN</h4>
            @if(count($keuangan) > 0)
                <table class="data">
                    <thead><tr><th width="30">No</th><th>Uraian</th><th>Kategori</th><th width="130">Jumlah (Rp)</th></tr></thead>
                    <tbody>
                        @foreach($keuangan as $i => $row)
                        <tr><td class="text-center">{{ $i + 1 }}</td><td>{{ $row->keterangan ?? '-' }}</td><td>{{ $row->kategori ?? '-' }}</td><td class="text-right">{{ number_format($row->nominal ?? 0, 0, ',', '.') }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot><tr><td colspan="3" class="text-right">Total</td><td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td></tr></tfoot>
                </table>
            @else
                <p>Belum ada data keuangan.</p>
            @endif
        </div>
        <div class="section">
            <h4>D. PESERTA</h4>
            @if(count($pendaftarans) > 0)
                <table class="data">
                    <thead><tr><th width="30">No</th><th>Nama</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($pendaftarans as $i => $p)
                        <tr><td class="text-center">{{ $i + 1 }}</td><td>{{ $p->users->name ?? $p->nama_pendaftar ?? '-' }}</td><td>{{ ucfirst($p->status ?? '-') }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Belum ada peserta terdaftar.</p>
            @endif
        </div>
    @endif

    {{-- PENUTUP --}}
    <div class="section">
        <p>Demikian laporan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    {{-- TANDA TANGAN --}}
    @if(in_array($jenis, ['proposal', 'lengkap']))
        @include('exports.partials.tanda-tangan', ['type' => 'panitia'])
    @elseif($jenis === 'sk')
        @include('exports.partials.tanda-tangan', ['type' => 'sk'])
    @else
        @include('exports.partials.tanda-tangan', ['type' => 'pembina-ketua'])
    @endif

    {{-- FOOTER --}}
    @include('exports.partials.footer')

</body>
</html>
