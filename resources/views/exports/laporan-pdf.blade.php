<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan {{ $jenisLabel }} - {{ $acaraName }}</title>
    <style>
        @page { margin: 3cm 3cm 3cm 4cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.5;
        }

        /* ===== KOP SURAT ===== */
        .kop { text-align: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 3px double #000; }
        .kop .logo { height: 70px; margin-bottom: 4px; }
        .kop h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 4px 0 0; letter-spacing: 2px; }
        .kop h2 { font-size: 11pt; font-weight: normal; margin: 2px 0; }
        .kop .alamat { font-size: 8pt; font-style: italic; color: #333; }

        /* ===== TITLE / JUDUL ===== */
        .title { text-align: center; margin: 24px 0; }
        .title h3 { font-size: 14pt; font-weight: bold; text-decoration: underline; margin: 0 0 4px; text-transform: uppercase; letter-spacing: 1px; }
        .title p { font-size: 10pt; margin: 2px 0; }

        /* ===== INFO SURAT ===== */
        .info-surat { margin: 16px 0; font-size: 11pt; }
        .info-surat table { width: 100%; border-collapse: collapse; }
        .info-surat td { padding: 3px 4px; vertical-align: top; }
        .info-surat .label { width: 120px; font-weight: bold; }

        /* ===== ALAMAT TUJUAN ===== */
        .alamat-tujuan { margin: 16px 0; font-size: 11pt; }
        .alamat-tujuan table { width: 100%; border-collapse: collapse; }
        .alamat-tujuan td { padding: 2px 4px; vertical-align: top; }
        .alamat-tujuan .label { width: 80px; }

        /* ===== BODY TEXT ===== */
        .body-text { margin: 16px 0; text-align: justify; font-size: 12pt; }
        .body-text p { margin: 6px 0; text-indent: 40px; }
        .body-text .no-indent { text-indent: 0; }

        /* ===== TABLE DATA ===== */
        table.data { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 10pt; }
        table.data th {
            background: #e2e8f0;
            border: 1px solid #000;
            padding: 7px 8px;
            text-align: center;
            font-weight: bold;
        }
        table.data td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 40px; width: 100%; }
        .signature td { width: 50%; vertical-align: top; padding: 0 20px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 40px; }
        .signature .line { display: inline-block; width: 200px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 11pt; }
        .signature .jabatan { font-size: 10pt; margin-top: 2px; }

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

    {{-- ===== JUDUL DOKUMEN ===== --}}
    <div class="title">
        <h3>{{ $jenisLabel }}</h3>
        <p>{{ $acaraName }}</p>
    </div>

    {{-- ===== INFO DOKUMEN ===== --}}
    <table class="info-surat">
        <tr>
            <td class="label">Nama Acara</td>
            <td>: {{ $acaraName }}</td>
        </tr>
        @if($acaraTanggal)
        <tr>
            <td class="label">Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}</td>
        </tr>
        @endif
        @if($acaraTempat)
        <tr>
            <td class="label">Tempat</td>
            <td>: {{ $acaraTempat }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Jenis Laporan</td>
            <td>: {{ $jenisLabel }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>: {{ ucfirst($status ?? 'Disetujui') }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Dibuat</td>
            <td>: {{ now()->translatedFormat('l, d F Y') }}</td>
        </tr>
    </table>

    {{-- ===== PEMBUKA ===== --}}
    <div class="body-text">
        <p>
            Yang bertanda tangan di bawah ini, Ketua Himpunan Mahasiswa Teknik Informatika (HIMANIKKA)
            Universitas Pahlawan Tuanku Tambusai, dengan ini menerangkan bahwa:
        </p>
    </div>

    {{-- ===== TABEL DATA ===== --}}
    <table class="data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Uraian</th>
                <th width="80">Volume</th>
                <th width="150">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item['uraian'] ?? $item }}</td>
                <td class="text-center">{{ $item['volume'] ?? '1' }}</td>
                <td>{{ $item['keterangan'] ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ===== PENUTUP ===== --}}
    <div class="body-text">
        <p>
            Demikian {{ strtolower($jenisLabel) }} ini dibuat dengan sebenar-benarnya untuk dapat
            dipergunakan sebagaimana mestinya.
        </p>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'pembina-ketua'])

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
