<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $judul ?? 'HIMANIKKA' }}</title>
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
        .title .nomor-surat { font-size: 11pt; margin: 4px 0; }
        .title .lampiran { font-size: 10pt; margin: 2px 0; }

        /* ===== INFO / NOMOR SURAT ===== */
        .info-surat { margin: 16px 0; font-size: 11pt; }
        .info-surat table { width: 100%; border-collapse: collapse; }
        .info-surat td { padding: 3px 4px; vertical-align: top; }
        .info-surat .label { width: 120px; font-weight: bold; }

        /* ===== BODY TEXT ===== */
        .body-text { margin: 16px 0; text-align: justify; font-size: 11pt; }
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
            font-size: 10pt;
        }
        table.data td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }
        table.data .bg-gray { background: #f1f5f9; }
        table.data .bold { font-weight: bold; }
        table.data tfoot td { font-weight: bold; background: #f1f5f9; }

        /* ===== SUMMARY / RINGKASAN ===== */
        .summary { margin: 16px 0; font-size: 11pt; }
        .summary table { width: 60%; margin-left: auto; border-collapse: collapse; }
        .summary td { padding: 5px 8px; border: 1px solid #000; }
        .summary .label { font-weight: bold; width: 200px; }
        .summary .total-row { font-weight: bold; background: #e2e8f0; }

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

        /* ===== PEMBUKA / PENUTUP ===== */
        .pembuka { margin: 16px 0; font-size: 11pt; text-align: justify; }
        .pembuka p { margin: 4px 0; text-indent: 40px; }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    @include('exports.partials.kop-surat')

    {{-- ===== JUDUL DOKUMEN ===== --}}
    <div class="title">
        <h3>{{ $judul ?? 'LAPORAN KEUANGAN' }}</h3>
        <p class="nomor-surat">
            Nomor: {{ $nomorSurat ?? '---/LK/HIMANIKKA/UPTT/' . now()->format('m/Y') }}
        </p>
        <p class="lampiran">Periode: {{ $periode ?? 'Seluruh Periode' }}</p>
    </div>

    {{-- ===== PEMBUKA ===== --}}
    <div class="pembuka">
        <p>
            Yang bertanda tangan di bawah ini, Ketua Himpunan Mahasiswa Teknik Informatika (HIMANIKKA)
            Universitas Pahlawan Tuanku Tambusai, dengan ini menyampaikan laporan keuangan
            periode {{ $periode ?? 'yang telah berjalan' }} sebagai berikut:
        </p>
    </div>

    {{-- ===== TABEL DATA KEUANGAN ===== --}}
    <table class="data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Acara</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th width="120">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalPengeluaran = 0;
            @endphp
            @forelse($items as $i => $item)
            @php
                $nominal = (float) ($item['nominal'] ?? 0);
                $jenis = $item['jenis'] ?? $item->jenis ?? 'pemasukan';
                if (strtolower($jenis) === 'pemasukan') {
                    $totalPemasukan += $nominal;
                } else {
                    $totalPengeluaran += $nominal;
                }
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item['tanggal'] ?? ($item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-') }}</td>
                <td>{{ $item['user'] ?? ($item->user?->name ?? '-') }}</td>
                <td>{{ $item['acara'] ?? ($item->acara?->name_acara ?? '-') }}</td>
                <td class="text-center">{{ ucfirst($jenis) }}</td>
                <td>{{ $item['kategori'] ?? $item->kategori ?? '-' }}</td>
                <td class="text-right">{{ number_format($nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Tidak ada data keuangan</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ===== RINGKASAN ===== --}}
    @if(count($items) > 0)
    <div class="summary">
        <table>
            <tr>
                <td class="label">Total Pemasukan</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Pengeluaran</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">Saldo Bersih</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    @endif

    {{-- ===== PENUTUP ===== --}}
    <div class="body-text">
        <p>
            Demikian laporan keuangan ini dibuat dengan sebenar-benarnya untuk pertanggungjawaban pengelolaan dana
            Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai.
        </p>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'pembina-ketua'])

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
