{{--
    ============================================================
    KOP SURAT HIMANIKKA — Shared Letterhead for PDF Exports
    ============================================================
    Kop surat menggunakan negative margin untuk meng-offset
    @page margin (3cm kiri/kanan/bawah, 4cm kiri) agar
    kop surat stretch penuh ke tepi halaman, tidak terpotong margin.
    
    Expected variables:
    - $profil (optional)               : Profil model instance from database
    - $struktur (optional)             : Struktur model instance (untuk kontak telp)
    - $logo_himanikka_base64 (optional): Base64 data URI for HIMANIKKA logo
    - $logo_univ_base64 (optional)     : Base64 data URI for university logo
    - $acaraName (optional)            : Nama acara (ditampilkan di kop jika ada)
    - $acaraTempat (optional)          : Tempat acara
    - $acaraTanggal (optional)         : Tanggal acara
    ============================================================
--}}

{{--
    Negative margin meng-offset @page margin (3cm kanan/bawah, 4cm kiri, 3cm atas)
    sehingga kop surat stretch penuh ke tepi halaman.
--}}
<div class="kop-surat" style="margin:-3cm -3cm 0 -4cm; padding:0; font-family:'Times New Roman';">
    <table style="width:100%; border-collapse:collapse; border:none;">
        <tr>
            {{-- Logo Universitas (Kiri) — agak ketengah --}}
            <td style="width:20%; text-align:left; vertical-align:top; padding:0 0 6px 1.8cm; border:none;">
                @if(isset($logo_univ_base64))
                    <img src="{{ $logo_univ_base64 }}" alt="Logo Universitas" class="logo"
                         style="height:50px; display:block; margin:0;">
                @endif
            </td>

            {{-- Teks Pusat — Nama, Alamat, Kontak --}}
            <td style="width:60%; text-align:center; vertical-align:top; padding:0 0 6px; border:none;">

                <h1 style="margin:1px 4px; font-size:10pt; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px; line-height:1.2; color:#1a1a1a;">
                    Panitia Pelaksana {{ $acaraName ?? 'HIMANIKKA' }}
                </h1>
                {{-- H1: Nama Organisasi --}}
                <h1 style="margin:1px 4px; font-size:10pt; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px; line-height:1.2; color:#1a1a1a;">
                    {{ $profil->name_instansi ?? 'HIMANIKKA' }}
                </h1>

                {{-- H2: Fakultas --}}
                <h2 style="margin:0 4px; font-size:9pt; font-weight:bold; text-transform:uppercase; letter-spacing:1px; line-height:1.1; color:#222;">
                    Fakultas Teknik
                </h2>

                {{-- H3: Universitas --}}
                <h3 style="margin:0 4px; font-size:9pt; font-weight:bold; text-transform:uppercase; letter-spacing:1px; line-height:1.1; color:#333;">
                    {{ $profil->alamat ?? 'Universitas Pahlawan Tuanku Tambusai' }}
                </h3>

                {{-- Alamat & Kontak --}}
                <p style="margin:0 4px 0; font-size:7pt; text-align:center; line-height:1.2; color:#555;">
                    Jl. Tuanku Tambusai No. 23, Bangkinang Kota, Kab. Kampar, Provinsi Riau 28156
                </p>
                <p style="margin:0 4px 0; font-size:7pt; text-align:center; line-height:1.2; color:#555;">
                    <a href="https://himanikka.uns.ac.id" style="color:#555; text-decoration:none;">https://himanikka.uns.ac.id</a>
                </p>
            </td>

            {{-- Logo HIMANIKKA (Kanan) — agak ketengah --}}
            <td style="width:20%; text-align:right; vertical-align:top; padding:0 1.8cm 6px 0; border:none;">
                @if(isset($logo_himanikka_base64))
                    <img src="{{ $logo_himanikka_base64 }}"
                         alt="Logo {{ $profil->singkatan ?? 'HIMANIKKA' }}" class="logo"
                         style="height:45px; display:block; margin:0 0 0 auto;">
                @endif
            </td>
        </tr>

        {{-- Batasan (garis ganda) — pas di bawah logo --}}
        <tr>
            <td colspan="3" style="padding:0; border:none;">
                <div style="
                    border-top: 2px double #000;
                    width: 100%;
                    margin-top: 0;
                "></div>
            </td>
        </tr>
    </table>
</div>
