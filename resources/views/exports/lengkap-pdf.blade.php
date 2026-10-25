<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN KEGIATAN - {{ $acaraName }}</title>
    <style>
        @page {
            margin: 3cm 3cm 3cm 4cm;
        }
        @page :first {
            margin-top: 2.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.6;
        }

        /* ===== PAGE BREAK ===== */
        .page-break {
            page-break-before: always;
        }

        /* ===== TITLE ===== */
        .title {
            text-align: center;
            margin: 60px 0 40px;
        }
        .title h1 {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0 0 8px;
        }
        .title h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 6px;
        }
        .title .sub {
            font-size: 11pt;
            margin: 4px 0;
        }
        .title .logo-besar {
            height: 100px;
            margin-bottom: 16px;
        }

        /* ===== SECTION / BAB ===== */
        .section { margin: 20px 0; text-align: justify; }
        .section h3.bab {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin: 30px 0 20px;
            letter-spacing: 2px;
        }
        .section h4 {
            font-size: 12pt;
            font-weight: bold;
            margin: 20px 0 10px;
            text-transform: uppercase;
        }
        .section h5 {
            font-size: 11pt;
            font-weight: bold;
            margin: 14px 0 8px;
        }
        .section p {
            margin: 8px 0;
            text-indent: 40px;
        }
        .section .no-indent {
            text-indent: 0;
        }
        .section .tab-list {
            margin: 4px 0 4px 20px;
            padding-left: 30px;
        }
        .section ol, .section ul {
            margin: 4px 0 4px 30px;
            padding-left: 10px;
        }
        .section li {
            margin: 4px 0;
            text-align: justify;
        }

        /* ===== KATA PENGANTAR ===== */
        .kata-pengantar {
            margin: 20px 0;
            text-align: justify;
        }
        .kata-pengantar p {
            margin: 8px 0;
            text-indent: 40px;
        }
        .kata-pengantar .ttd-pengantar {
            margin-top: 50px;
            text-align: right;
        }
        .kata-pengantar .ttd-pengantar .nama {
            font-weight: bold;
            margin-top: 60px;
        }

        /* ===== DAFTAR ISI ===== */
        .daftar-isi {
            margin: 20px 0;
        }
        .daftar-isi h3 {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin: 0 0 24px;
            letter-spacing: 2px;
        }
        .daftar-isi table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }
        .daftar-isi td {
            padding: 4px 2px;
            vertical-align: top;
        }
        .daftar-isi .no { width: 40px; text-align: center; }
        .daftar-isi .hal { width: 60px; text-align: right; }
        .daftar-isi .judul { font-weight: bold; }
        .daftar-isi .sub-judul td {
            padding-left: 30px;
            font-size: 10pt;
        }
        .daftar-isi .dots {
            color: #999;
            letter-spacing: 1px;
        }

        /* ===== TABLE DATA ===== */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 14px 0;
            font-size: 10pt;
        }
        table.data th {
            background: #e2e8f0;
            border: 1px solid #000;
            padding: 7px 8px;
            text-align: center;
            font-weight: bold;
        }
        table.data td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }
        table.data .text-right { text-align: right; }
        table.data .text-center { text-align: center; }
        table.data .text-left { text-align: left; }
        table.data .bg-green { background: #dcfce7; }
        table.data .bg-red { background: #fee2e2; }
        table.data .bg-gray { background: #f1f5f9; }
        table.data .bold { font-weight: bold; }
        table.data tfoot td { font-weight: bold; background: #f1f5f9; }

        /* ===== INFO TABLE ===== */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11pt;
        }
        .info-table td {
            padding: 3px 4px;
            vertical-align: top;
        }
        .info-table .label {
            width: 160px;
            font-weight: bold;
        }
        .info-table .label-sm {
            width: 120px;
            font-weight: bold;
        }

        /* ===== LAMPIRAN ===== */
        .lampiran-item {
            margin: 24px 0;
            page-break-inside: avoid;
        }
        .lampiran-item h4 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 10px;
            text-transform: uppercase;
        }
        .lampiran-item .dok-img {
            text-align: center;
            margin: 10px 0;
        }
        .lampiran-item .dok-img img {
            max-width: 80%;
            height: auto;
            border: 1px solid #ccc;
        }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 40px; width: 100%; }
        .signature td { width: 50%; vertical-align: top; padding: 0 20px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 40px; }
        .signature .line { display: inline-block; width: 200px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 11pt; }
        .signature .jabatan { font-size: 10pt; margin-top: 2px; }

        .signature-3col td { width: 33%; }
        .signature-5col td { width: 20%; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #64748b;
            padding: 4px 0;
            border-top: 1px solid #cbd5e1;
        }
        .footer .pageNumber { font-weight: bold; }
    </style>
</head>
<body>

    {{-- ================================================================ --}}
    {{-- HALAMAN JUDUL / COVER                                                  --}}
    {{-- ================================================================ --}}
    <div class="title" style="padding-top: 80px;">
        @if(isset($logo_himanikka_base64))
            <img src="{{ $logo_himanikka_base64 }}" alt="Logo" class="logo-besar">
        @endif
        <h1>{{ $jenisLabel ?? 'LAPORAN KEGIATAN' }}</h1>
        <h2>{{ $acaraName }}</h2>
        <div class="sub">
            {{ $nomorSurat ?? '---/LAP/HIMANIKKA/UPTT/' . now()->format('m/Y') }}
        </div>
        <br>
        <div class="sub" style="margin-top: 30px;">
            <strong>Panitia Pelaksana</strong><br>
            {{ $profil->name_instansi ?? 'HIMANIKKA' }}<br>
            {{ $profil->alamat ?? 'Universitas Pahlawan Tuanku Tambusai' }}<br>
            {{ now()->format('Y') }}
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- KATA PENGANTAR                                                    --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="kata-pengantar">
        <h3 style="font-size:13pt; font-weight:bold; text-align:center; text-transform:uppercase; margin-bottom:24px; letter-spacing:2px;">
            KATA PENGANTAR
        </h3>

        <p>Assalamu'alaikum Wr. Wb.</p>

        <p>
            Puji dan syukur kami panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, atas limpahan
            rahmat dan karunia-Nya sehingga kami dapat menyelesaikan laporan kegiatan
            <strong>{{ $acaraName }}</strong> ini dengan baik dan tepat waktu.
        </p>

        <p>
            Laporan ini disusun sebagai bentuk pertanggungjawaban dan dokumentasi atas seluruh rangkaian
            kegiatan yang telah dilaksanakan oleh Panitia Pelaksana {{ $acaraName }} Himpunan Mahasiswa
            Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai. Penyusunan laporan ini
            bertujuan untuk memberikan gambaran yang komprehensif mengenai pelaksanaan kegiatan, mulai
            dari tahap perencanaan, persiapan, pelaksanaan, hingga evaluasi kegiatan.
        </p>

        <p>
            Kami menyadari bahwa laporan ini masih jauh dari kesempurnaan. Oleh karena itu, kami sangat
            mengharapkan kritik dan saran yang membangun dari semua pihak untuk perbaikan di masa yang
            akan datang. Semoga laporan ini dapat memberikan manfaat bagi seluruh pembaca dan menjadi
            bahan evaluasi untuk kegiatan-kegiatan selanjutnya.
        </p>

        <p>Wassalamu'alaikum Wr. Wb.</p>

        <div class="ttd-pengantar">
            <p class="no-indent">Bangkinang, {{ now()->translatedFormat('d F Y') }}</p>
            <br><br>
            <div class="nama">Ketua Panitia Pelaksana,</div>
            <br><br><br>
            <div class="nama" style="text-decoration:underline;">{{ $ketuaPelaksana ?? '_________________' }}</div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DAFTAR ISI                                                       --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="daftar-isi">
        <h3>DAFTAR ISI</h3>

        <table>
            <tr>
                <td class="no">I</td>
                <td>KATA PENGANTAR</td>
                <td class="hal">i</td>
            </tr>
            <tr>
                <td class="no">II</td>
                <td>DAFTAR ISI</td>
                <td class="hal">ii</td>
            </tr>
            <tr>
                <td class="no">III</td>
                <td>DAFTAR TABEL</td>
                <td class="hal">iii</td>
            </tr>
            <tr>
                <td class="no">IV</td>
                <td>DAFTAR LAMPIRAN</td>
                <td class="hal">iii</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">BAB I</td>
                <td class="judul" style="padding-top: 12px;">PENDAHULUAN</td>
                <td class="hal" style="padding-top: 12px;">1</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>A. Latar Belakang</td>
                <td>1</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>B. Nama dan Tema Kegiatan</td>
                <td>2</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>C. Tujuan Kegiatan</td>
                <td>2</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>D. Manfaat Kegiatan</td>
                <td>3</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">BAB II</td>
                <td class="judul" style="padding-top: 12px;">PROFIL ORGANISASI</td>
                <td class="hal" style="padding-top: 12px;">4</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>A. Sejarah Singkat</td>
                <td>4</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>B. Visi dan Misi</td>
                <td>4</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>C. Struktur Organisasi</td>
                <td>5</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">BAB III</td>
                <td class="judul" style="padding-top: 12px;">PELAKSANAAN KEGIATAN</td>
                <td class="hal" style="padding-top: 12px;">6</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>A. Waktu dan Tempat</td>
                <td>6</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>B. Susunan Panitia</td>
                <td>6</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>C. Peserta Kegiatan</td>
                <td>7</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>D. Rangkaian Acara</td>
                <td>7</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">BAB IV</td>
                <td class="judul" style="padding-top: 12px;">HASIL DAN PEMBAHASAN</td>
                <td class="hal" style="padding-top: 12px;">8</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>A. Hasil Pelaksanaan Kegiatan</td>
                <td>8</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>B. Laporan Keuangan</td>
                <td>9</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>C. Evaluasi Kegiatan</td>
                <td>10</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">BAB V</td>
                <td class="judul" style="padding-top: 12px;">PENUTUP</td>
                <td class="hal" style="padding-top: 12px;">11</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>A. Kesimpulan</td>
                <td>11</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>B. Saran</td>
                <td>11</td>
            </tr>
            <tr>
                <td class="no judul" style="padding-top: 12px;">V</td>
                <td class="judul" style="padding-top: 12px;">LAMPIRAN</td>
                <td class="hal" style="padding-top: 12px;">12</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>Lampiran 1: Dokumentasi Kegiatan</td>
                <td>12</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>Lampiran 2: Daftar Hadir Peserta</td>
                <td>13</td>
            </tr>
            <tr class="sub-judul">
                <td></td>
                <td>Lampiran 3: Surat Keputusan</td>
                <td>14</td>
            </tr>
        </table>
    </div>

    {{-- ================================================================ --}}
    {{-- BAB I: PENDAHULUAN                                               --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">BAB I<br>PENDAHULUAN</h3>

        <h4>A. Latar Belakang</h4>
        <p>
            Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai
            sebagai organisasi kemahasiswaan memiliki peran strategis dalam mengembangkan potensi
            dan kreativitas mahasiswa di bidang Teknik Informatika. Sebagai wadah pengembangan diri
            mahasiswa, HIMANIKKA secara rutin menyelenggarakan berbagai kegiatan yang bertujuan untuk
            meningkatkan kompetensi, memperluas wawasan, serta mempererat tali silaturahmi antar
            mahasiswa.
        </p>
        <p>
            Kegiatan <strong>{{ $acaraName }}</strong> merupakan salah satu program kerja yang
            diselenggarakan oleh HIMANIKKA dalam rangka {{ $acaraTipe ? 'kegiatan ' . $acaraTipe : 'pengembangan mahasiswa' }}.
            Kegiatan ini dilandasi oleh kebutuhan untuk {{ $keteranganAcara ?? 'mengembangkan potensi dan kreativitas mahasiswa Teknik Informatika di lingkungan Universitas Pahlawan Tuanku Tambusai' }}.
        </p>
        <p>
            Laporan ini disusun sebagai bentuk dokumentasi dan pertanggungjawaban atas seluruh
            rangkaian kegiatan yang telah dilaksanakan. Melalui laporan ini, diharapkan seluruh
            pihak dapat memperoleh gambaran yang jelas dan komprehensif mengenai pelaksanaan
            kegiatan {{ $acaraName }}.
        </p>

        <h4>B. Nama dan Tema Kegiatan</h4>
        <table class="info-table">
            <tr>
                <td class="label-sm">Nama Kegiatan</td>
                <td>: <strong>{{ $acaraName }}</strong></td>
            </tr>
            <tr>
                <td class="label-sm">Tema</td>
                <td>: "{{ $acaraTipe ?? 'Meningkatkan Kreativitas dan Inovasi Mahasiswa Teknik Informatika' }}"</td>
            </tr>
        </table>

        <h4>C. Tujuan Kegiatan</h4>
        <p>Adapun tujuan dari pelaksanaan kegiatan ini adalah sebagai berikut:</p>
        <ol>
            <li>Meningkatkan wawasan dan pengetahuan mahasiswa di bidang Teknik Informatika;</li>
            <li>Mengembangkan bakat dan minat mahasiswa dalam kegiatan non-akademik;</li>
            <li>Mempererat tali silaturahmi antar mahasiswa Teknik Informatika;</li>
            <li>Meningkatkan kreativitas dan inovasi mahasiswa dalam berkarya;</li>
            <li>{{ $keteranganAcara ?? 'Mewujudkan kegiatan yang bermanfaat bagi seluruh civitas akademika.' }}</li>
        </ol>

        <h4>D. Manfaat Kegiatan</h4>
        <p>Kegiatan ini diharapkan dapat memberikan manfaat sebagai berikut:</p>
        <ol>
            <li>Bagi Mahasiswa: Meningkatkan soft skill, hard skill, dan jaringan pertemanan;</li>
            <li>Bagi Organisasi: Meningkatkan eksistensi dan kredibilitas HIMANIKKA;</li>
            <li>Bagi Universitas: Menghasilkan mahasiswa yang aktif, kreatif, dan berprestasi.</li>
        </ol>
    </div>

    {{-- ================================================================ --}}
    {{-- BAB II: PROFIL ORGANISASI                                         --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">BAB II<br>PROFIL ORGANISASI</h3>

        <h4>A. Sejarah Singkat</h4>
        <p>
            {{ $profil->sejarah ?? 'Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) adalah organisasi kemahasiswaan di Program Studi Teknik Informatika Universitas Pahlawan Tuanku Tambusai yang didirikan sebagai wadah pengembangan minat, bakat, dan potensi mahasiswa Teknik Informatika. HIMANIKKA berperan aktif dalam berbagai kegiatan akademik dan non-akademik, serta menjadi mitra strategis program studi dalam mencetak lulusan yang kompeten dan berkarakter.' }}
        </p>

        <h4>B. Visi dan Misi</h4>
        <p><strong>Visi:</strong></p>
        <p style="font-style: italic; text-align: center; font-weight: bold;">
            "{{ $profil->visi ?? 'Terwujudnya Himpunan Mahasiswa Teknik Informatika yang unggul, inovatif, dan berdaya saing tinggi di bidang teknologi informasi serta berlandaskan iman dan takwa.' }}"
        </p>

        <p><strong>Misi:</strong></p>
        <ol>
            @if($profil && $profil->misi)
                @foreach(explode("\n", $profil->misi) as $misiItem)
                    @if(trim($misiItem))
                        <li>{{ trim($misiItem) }}</li>
                    @endif
                @endforeach
            @else
                <li>Meningkatkan kualitas sumber daya mahasiswa Teknik Informatika;</li>
                <li>Mengembangkan kegiatan yang kreatif, inovatif, dan bermanfaat bagi mahasiswa;</li>
                <li>Menjalin kerjasama yang harmonis dengan seluruh elemen kampus dan masyarakat;</li>
                <li>Menerapkan nilai-nilai profesionalisme dan integritas dalam setiap kegiatan;</li>
                <li>Menciptakan lingkungan organisasi yang kondusif untuk pengembangan diri.</li>
            @endif
        </ol>

        <h4>C. Struktur Organisasi</h4>
        <p>Berikut adalah struktur kepengurusan {{ $profil->name_instansi ?? 'HIMANIKKA' }}:</p>
        <table class="info-table">
            <tr>
                <td class="label-sm">Pelindung</td>
                <td>: Rektor Universitas Pahlawan Tuanku Tambusai</td>
            </tr>
            <tr>
                <td class="label-sm">Pembina</td>
                <td>: Pembina HIMANIKKA</td>
            </tr>
            <tr>
                <td class="label-sm">Ketua</td>
                <td>: Ketua HIMANIKKA</td>
            </tr>
            <tr>
                <td class="label-sm">Sekretaris</td>
                <td>: Sekretaris HIMANIKKA</td>
            </tr>
            <tr>
                <td class="label-sm">Bendahara</td>
                <td>: Bendahara HIMANIKKA</td>
            </tr>
        </table>
    </div>

    {{-- ================================================================ --}}
    {{-- BAB III: PELAKSANAAN KEGIATAN                                     --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">BAB III<br>PELAKSANAAN KEGIATAN</h3>

        <h4>A. Waktu dan Tempat</h4>
        <p>Kegiatan <strong>{{ $acaraName }}</strong> dilaksanakan pada:</p>
        <table class="info-table">
            <tr>
                <td class="label-sm">Hari/Tanggal</td>
                <td>:
                    @if($acaraTanggal)
                        {{ \Carbon\Carbon::parse($acaraTanggal)->translatedFormat('l, d F Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label-sm">Tempat</td>
                <td>: {{ $acaraTempat ?? 'Lingkungan Universitas Pahlawan Tuanku Tambusai' }}</td>
            </tr>
            <tr>
                <td class="label-sm">Waktu</td>
                <td>: {{ now()->format('H:i') }} WIB - Selesai</td>
            </tr>
        </table>

        <h4>B. Susunan Panitia</h4>
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
                <tr><td class="text-center">3</td><td>Ketua Pelaksana</td><td>{{ $ketuaPelaksana ?? $pj ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">4</td><td>Sekretaris</td><td>{{ $sekretaris ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">5</td><td>Bendahara</td><td>{{ $bendahara ?? 'Mahasiswa Teknik Informatika' }}</td></tr>
                <tr><td class="text-center">6</td><td>Seksi Acara</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">7</td><td>Seksi Perlengkapan</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">8</td><td>Seksi Konsumsi</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">9</td><td>Seksi Dokumentasi & Publikasi</td><td>Mahasiswa Teknik Informatika</td></tr>
                <tr><td class="text-center">10</td><td>Seksi Keamanan & Ketertiban</td><td>Mahasiswa Teknik Informatika</td></tr>
            </tbody>
        </table>

        <h4>C. Peserta Kegiatan</h4>
        <p>
            Kegiatan <strong>{{ $acaraName }}</strong> diikuti oleh peserta dari kalangan mahasiswa
            Teknik Informatika Universitas Pahlawan Tuanku Tambusai.
        </p>
        @if(isset($jumlahPeserta))
        <table class="info-table">
            <tr>
                <td class="label-sm">Jumlah Pendaftar</td>
                <td>: {{ $jumlahPeserta }} orang</td>
            </tr>
            <tr>
                <td class="label-sm">Jumlah Hadir</td>
                <td>: {{ $jumlahPeserta }} orang</td>
            </tr>
        </table>
        @endif

        @if(isset($pendaftarans) && count($pendaftarans) > 0)
        <p>Daftar peserta kegiatan:</p>
        <table class="data">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftarans as $i => $p)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $p->users->name ?? $p->nama_pendaftar ?? '-' }}</td>
                    <td>{{ ucfirst($p->status ?? 'Hadir') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <h4>D. Rangkaian Acara</h4>
        <p>Berikut adalah rangkaian acara yang telah dilaksanakan:</p>
        <table class="data">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Waktu</th>
                    <th>Kegiatan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="text-center">1</td><td>07.30 - 08.00</td><td>Registrasi Peserta</td><td>Pendaftaran ulang peserta</td></tr>
                <tr><td class="text-center">2</td><td>08.00 - 08.30</td><td>Pembukaan</td><td>Pembacaan doa dan menyanyikan lagu Indonesia Raya</td></tr>
                <tr><td class="text-center">3</td><td>08.30 - 09.00</td><td>Sambutan</td><td>Sambutan Ketua Panitia, Ketua HIMANIKKA, dan Pembina</td></tr>
                <tr><td class="text-center">4</td><td>09.00 - 10.30</td><td>Acara Inti</td><td>Pelaksanaan kegiatan utama</td></tr>
                <tr><td class="text-center">5</td><td>10.30 - 11.00</td><td>Diskusi & Tanya Jawab</td><td>Sesi interaktif dengan peserta</td></tr>
                <tr><td class="text-center">6</td><td>11.00 - 11.30</td><td>Penutupan</td><td>Kesimpulan, foto bersama, dan doa</td></tr>
            </tbody>
        </table>
    </div>

    {{-- ================================================================ --}}
    {{-- BAB IV: HASIL DAN PEMBAHASAN                                      --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">BAB IV<br>HASIL DAN PEMBAHASAN</h3>

        <h4>A. Hasil Pelaksanaan Kegiatan</h4>
        <p>
            Kegiatan <strong>{{ $acaraName }}</strong> telah dilaksanakan dengan baik dan lancar
            sesuai dengan rencana yang telah ditetapkan. Seluruh rangkaian acara berjalan dengan
            tertib dan kondusif. Partisipasi peserta sangat antusias dan memberikan respons positif
            terhadap kegiatan yang diselenggarakan.
        </p>
        <p>
            Berdasarkan hasil pelaksanaan kegiatan, dapat dilaporkan beberapa capaian sebagai berikut:
        </p>
        <ol>
            <li>Kegiatan berjalan sesuai dengan jadwal yang telah ditentukan;</li>
            <li>Peserta yang hadir mencapai target yang telah ditetapkan;</li>
            <li>Seluruh rangkaian acara terlaksana tanpa kendala yang berarti;</li>
            <li>Mendapatkan apresiasi positif dari peserta dan pihak universitas.</li>
        </ol>

        <h4>B. Laporan Keuangan</h4>
        <p>Berikut adalah laporan keuangan kegiatan <strong>{{ $acaraName }}</strong>:</p>

        @if(isset($keuangan) && count($keuangan) > 0)
            @php
                $pemasukan = $keuangan->where('jenis', 'pemasukan');
                $pengeluaran = $keuangan->where('jenis', 'pengeluaran');
                $totalPemasukan = $pemasukan->sum('nominal');
                $totalPengeluaran = $pengeluaran->sum('nominal');
                $saldoAkhir = $totalPemasukan - $totalPengeluaran;
            @endphp

            <p><strong>1) Pemasukan</strong></p>
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
                    <tr class="bg-green bold">
                        <td colspan="3" class="text-right">Total Pemasukan</td>
                        <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <p><strong>2) Pengeluaran</strong></p>
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
                    <tr class="bg-red bold">
                        <td colspan="3" class="text-right">Total Pengeluaran</td>
                        <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <p><strong>3) Rekapitulasi Anggaran</strong></p>
            <table class="data">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Uraian</th>
                        <th width="130">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Total Pemasukan</td>
                        <td class="text-right bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Total Pengeluaran</td>
                        <td class="text-right bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray bold">
                        <td class="text-center">3</td>
                        <td>Saldo Akhir</td>
                        <td class="text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
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
                        <td class="text-right">{{ $item['biaya'] ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">Belum ada data keuangan</td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <h4>C. Evaluasi Kegiatan</h4>
        <p>
            Secara keseluruhan, kegiatan <strong>{{ $acaraName }}</strong> telah berjalan dengan baik
            dan sesuai dengan harapan. Namun demikian, terdapat beberapa catatan evaluasi yang perlu
            menjadi perhatian untuk kegiatan selanjutnya:
        </p>

        <p><strong>Kelebihan:</strong></p>
        <ol>
            <li>Antusiasme peserta sangat tinggi terhadap kegiatan yang diselenggarakan;</li>
            <li>Koordinasi antar panitia berjalan dengan baik;</li>
            <li>Kegiatan selesai tepat waktu sesuai jadwal.</li>
        </ol>

        <p><strong>Kekurangan:</strong></p>
        <ol>
            <li>Sosialisasi kegiatan perlu dilakukan lebih awal dan lebih luas;</li>
            <li>Persiapan perlengkapan perlu dilakukan lebih matang;</li>
            <li>Manajemen waktu pada beberapa sesi perlu ditingkatkan.</li>
        </ol>
    </div>

    {{-- ================================================================ --}}
    {{-- BAB V: PENUTUP                                                    --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">BAB V<br>PENUTUP</h3>

        <h4>A. Kesimpulan</h4>
        <p>
            Berdasarkan uraian yang telah disampaikan pada bab-bab sebelumnya, dapat disimpulkan
            bahwa kegiatan <strong>{{ $acaraName }}</strong> yang diselenggarakan oleh Himpunan
            Mahasiswa Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai telah
            berjalan dengan baik, lancar, dan sesuai dengan rencana yang telah ditetapkan.
        </p>
        <p>
            Seluruh rangkaian kegiatan dapat terlaksana berkat kerjasama dan dukungan dari berbagai
            pihak, baik dari internal organisasi maupun eksternal. Partisipasi aktif dari peserta
            dan dedikasi tinggi dari seluruh panitia menjadi faktor kunci keberhasilan kegiatan ini.
        </p>

        <h4>B. Saran</h4>
        <p>
            Sebagai bahan perbaikan untuk kegiatan selanjutnya, kami merekomendasikan beberapa hal
            sebagai berikut:
        </p>
        <ol>
            <li>Perlu dilakukan sosialisasi yang lebih intensif dan menjangkau lebih banyak mahasiswa;</li>
            <li>Persiapan kegiatan sebaiknya dimulai lebih awal untuk mengantisipasi kendala teknis;</li>
            <li>Koordinasi antar seksi perlu ditingkatkan melalui rapat-rapat persiapan yang lebih terstruktur;</li>
            <li>Dokumentasi kegiatan perlu dilakukan secara lebih profesional dan lengkap;</li>
            <li>Perlu adanya sistem evaluasi yang lebih terukur untuk setiap aspek kegiatan.</li>
        </ol>

        <p>
            Demikian laporan kegiatan ini kami susun dengan sebenar-benarnya. Semoga laporan ini
            dapat memberikan gambaran yang jelas mengenai pelaksanaan kegiatan dan menjadi bahan
            evaluasi yang bermanfaat untuk kegiatan-kegiatan selanjutnya. Besar harapan kami agar
            kegiatan ini dapat terus dilaksanakan secara berkesinambungan dan memberikan manfaat
            yang sebesar-besarnya bagi seluruh pihak.
        </p>
    </div>

    {{-- ===== TANDA TANGAN BAB V ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'lpj'])

    {{-- ================================================================ --}}
    {{-- LAMPIRAN                                                          --}}
    {{-- ================================================================ --}}
    <div class="page-break"></div>
    @include('exports.partials.kop-surat')

    <div class="section">
        <h3 class="bab">LAMPIRAN</h3>

        {{-- LAMPIRAN 1: DOKUMENTASI --}}
        <div class="lampiran-item">
            <h4>Lampiran 1: Dokumentasi Kegiatan</h4>
            <p>
                Berikut adalah dokumentasi foto-foto selama pelaksanaan kegiatan
                <strong>{{ $acaraName }}</strong>:
            </p>

            @if(isset($dokumentasi) && count($dokumentasi) > 0)
                <table class="data">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Nama Dokumentasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokumentasi as $i => $dok)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $dok->name_dokumentasi ?? 'Dokumentasi ' . ($i + 1) }}</td>
                            <td>{{ $dok->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-indent: 0;">
                    Dokumentasi kegiatan {{ $acaraName }} terlampir dalam bentuk berkas foto
                    yang disertakan bersama laporan ini. Dokumentasi mencakup foto-foto selama
                    persiapan, pelaksanaan, dan penutupan kegiatan.
                </p>
            @endif
        </div>

        {{-- LAMPIRAN 2: DAFTAR HADIR --}}
        <div class="lampiran-item">
            <h4>Lampiran 2: Daftar Hadir Peserta</h4>
            <p>Daftar hadir peserta kegiatan <strong>{{ $acaraName }}</strong>:</p>

            @if(isset($pendaftarans) && count($pendaftarans) > 0)
                <table class="data">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Nama Peserta</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $i => $p)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $p->users->name ?? $p->nama_pendaftar ?? '-' }}</td>
                            <td>{{ ucfirst($p->status ?? 'Hadir') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-indent: 0;">Daftar hadir peserta terlampir dalam dokumen terpisah.</p>
            @endif
        </div>

        {{-- LAMPIRAN 3: SURAT KEPUTUSAN --}}
        <div class="lampiran-item">
            <h4>Lampiran 3: Surat Keputusan</h4>
            <p>
                Surat Keputusan tentang {{ $namaLaporan }} dengan Nomor:
                <strong>{{ $nomorSurat ?? '---/SK/HIMANIKKA/UPTT/' . now()->format('m/Y') }}</strong>
                terlampir dalam dokumen terpisah.
            </p>
            <table class="info-table">
                <tr>
                    <td class="label-sm">Nomor SK</td>
                    <td>: {{ $nomorSurat ?? '---/SK/HIMANIKKA/UPTT/' . now()->format('m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label-sm">Tanggal</td>
                    <td>: {{ now()->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label-sm">Tentang</td>
                    <td>: {{ $namaLaporan }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ===== TANDA TANGAN LAMPIRAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'pembina-ketua'])

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
