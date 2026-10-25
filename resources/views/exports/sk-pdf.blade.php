<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SURAT KEPUTUSAN - {{ $acaraName }}</title>
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
        .title h3 { font-size: 15pt; font-weight: bold; text-decoration: underline; margin: 0 0 8px; text-transform: uppercase; letter-spacing: 2px; }
        .title .nomor { font-size: 12pt; font-weight: bold; margin: 6px 0; text-transform: uppercase; }
        .title .tentang { font-size: 12pt; font-weight: bold; margin: 4px 0; text-transform: uppercase; font-style: italic; }

        /* ===== HEADER TEXT ===== */
        .header-text { text-align: center; margin: 12px 0; font-size: 12pt; }
        .header-text .bold { font-weight: bold; }

        /* ===== CONTENT / LEGAL TEXT ===== */
        .content { margin: 24px 0; text-align: justify; }
        .content p { margin: 6px 0; }
        .content .menimbang, .content .mengingat { margin: 12px 0; }
        .content .menimbang ol, .content .mengingat ol, .content .memutuskan ol { margin: 4px 0 4px 20px; padding-left: 30px; }
        .content .menimbang li, .content .mengingat li, .content .memutuskan li { margin: 3px 0; text-align: justify; }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 40px; width: 100%; }
        .signature td { width: 50%; vertical-align: top; padding: 0 20px; }
        .signature .right { text-align: center; }
        .signature .place-date { margin-bottom: 30px; font-size: 11pt; }
        .signature .sign-space { margin-top: 30px; }
        .signature .line { display: inline-block; width: 200px; border-top: 1px solid #000; }
        .signature .name { font-weight: bold; margin-top: 6px; font-size: 11pt; }
        .signature .jabatan { font-size: 10pt; margin-top: 2px; }

        /* ===== TEMBUSAN ===== */
        .tembusan { margin-top: 24px; font-size: 10pt; }
        .tembusan .title-tembusan { font-weight: bold; text-decoration: underline; margin-bottom: 6px; }
        .tembusan ol { margin: 2px 0 2px 20px; }

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
        <h3>SURAT KEPUTUSAN</h3>
        <p class="nomor">NOMOR: {{ $nomorSurat ?? '---/SK/HIMANIKKA/UPTT/' . now()->format('m/Y') }}</p>
        <p class="tentang">TENTANG</p>
        <p class="tentang">{{ strtoupper($namaLaporan) }}</p>
    </div>

    <div class="header-text">
        <p>KETUA HIMPUNAN MAHASISWA TEKNIK INFORMATIKA (HIMANIKKA)</p>
        <p>UNIVERSITAS PAHLAWAN TUANKU TAMBUSAI</p>
    </div>

    <div class="content">
        {{-- MENIMBANG --}}
        <div class="menimbang">
            <p><strong>Menimbang</strong> &nbsp;:</p>
            <ol type="a">
                <li>bahwa dalam rangka pelaksanaan kegiatan <strong>{{ $acaraName }}</strong>, perlu dibentuk panitia pelaksana dan menetapkan susunan kepanitiaan;</li>
                <li>bahwa untuk kelancaran pelaksanaan kegiatan tersebut, perlu diterbitkan Surat Keputusan sebagai dasar hukum pembentukan panitia;</li>
                <li>bahwa berdasarkan pertimbangan sebagaimana dimaksud dalam huruf a dan b, perlu menetapkan Surat Keputusan tentang {{ strtolower($namaLaporan) }}.</li>
            </ol>
        </div>

        {{-- MENGINGAT --}}
        <div class="mengingat">
            <p><strong>Mengingat</strong> &nbsp;:</p>
            <ol type="1">
                <li>Anggaran Dasar dan Anggaran Rumah Tangga HIMANIKKA;</li>
                <li>Program Kerja HIMANIKKA Periode {{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }};</li>
                <li>Rapat Koordinasi Pengurus HIMANIKKA tanggal {{ now()->translatedFormat('d F Y') }}.</li>
            </ol>
        </div>

        {{-- MEMUTUSKAN --}}
        <p style="margin-top: 16px;"><strong>Memutuskan</strong> :</p>
        <p style="margin-left: 20px; font-weight: bold;">MENETAPKAN :</p>

        <div class="memutuskan">
            <ol style="margin-left: 20px;">
                <li>Mengesahkan <strong>{{ $namaLaporan }}</strong> yang akan diselenggarakan oleh HIMANIKKA Universitas Pahlawan Tuanku Tambusai.</li>
                <li>Menetapkan susunan kepanitiaan <strong>{{ $acaraName }}</strong> sebagaimana tercantum dalam lampiran surat keputusan ini.</li>
                <li>Kepada panitia yang telah ditetapkan agar melaksanakan tugas dengan penuh tanggung jawab dan dedikasi tinggi.</li>
                <li>Segala biaya yang timbul akibat pelaksanaan kegiatan ini dibebankan pada anggaran HIMANIKKA dan/atau sumber dana lain yang sah dan tidak mengikat.</li>
                <li>Surat Keputusan ini berlaku sejak tanggal ditetapkan dan akan dievaluasi apabila terdapat kekeliruan dalam penetapannya.</li>
            </ol>
        </div>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    @include('exports.partials.tanda-tangan', ['type' => 'sk'])

    {{-- ===== TEMBUSAN ===== --}}
    <div class="tembusan">
        <p class="title-tembusan">Tembusan:</p>
        <ol type="1">
            <li>Rektor Universitas Pahlawan Tuanku Tambusai (sebagai laporan);</li>
            <li>Pembina HIMANIKKA;</li>
            <li>Ketua HIMANIKKA (arsip);</li>
            <li>Panitia Pelaksana {{ $acaraName }}.</li>
        </ol>
    </div>

    {{-- ===== FOOTER ===== --}}
    @include('exports.partials.footer')

</body>
</html>
