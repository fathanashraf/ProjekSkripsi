{{-- 
    ============================================================
    TANDA TANGAN — Shared Signature Block for PDF Exports
    ============================================================
    
    Usage examples:
    
    1. TWO signatures (Pembina + Ketua):
       @include('exports.partials.tanda-tangan', ['type' => 'pembina-ketua'])
    
    2. THREE signatures (Ketua Pelaksana + Sekretaris + Bendahara):
       @include('exports.partials.tanda-tangan', ['type' => 'panitia'])
    
    3. SINGLE signature (Ketua only):
       @include('exports.partials.tanda-tangan', ['type' => 'ketua'])
    
    4. LPJ (Ketua + Sekretaris then Pembina + Rektor):
       @include('exports.partials.tanda-tangan', ['type' => 'lpj'])
    
    5. SK (Ketua then Pembina + Rektor):
       @include('exports.partials.tanda-tangan', ['type' => 'sk'])
    
    Additional variables for names:
    - $ketuaPelaksana, $sekretaris, $bendahara (for panitia type)
    - The date is auto-generated using now()
    ============================================================
--}}

{{-- TYPE: PEMBINA + KETUA (default, 2 kolom) --}}
@if(!isset($type) || $type === 'pembina-ketua')
<table class="signature">
    <tr>
        <td>
            <div class="place-date">
                Mengetahui,<br>
                Pembina HIMANIKKA
            </div>
            <div class="sign-space">
                <div class="line"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
            </div>
        </td>
        <td class="right">
            <div class="place-date">
                Bangkinang, {{ now()->translatedFormat('d F Y') }}
            </div>
            <div class="sign-space">
                <div class="line"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
            </div>
        </td>
    </tr>
</table>

{{-- TYPE: KETUA PELAKSANA + SEKRETARIS + BENDAHARA (3 kolom) --}}
@elseif($type === 'panitia')
<table class="signature signature-3col">
    <tr>
        <td class="right">
            <div class="place-date">Bangkinang, {{ now()->translatedFormat('d F Y') }}</div>
            <div class="sign-space">
                <div class="jabatan">Ketua Pelaksana,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">{{ $ketuaPelaksana ?? '_________________' }}</div>
            </div>
        </td>
        <td class="right">
            <div class="place-date">&nbsp;</div>
            <div class="sign-space">
                <div class="jabatan">Sekretaris,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">{{ $sekretaris ?? '_________________' }}</div>
            </div>
        </td>
        <td class="right">
            <div class="place-date">&nbsp;</div>
            <div class="sign-space">
                <div class="jabatan">Bendahara,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">{{ $bendahara ?? '_________________' }}</div>
            </div>
        </td>
    </tr>
</table>
<table class="signature">
    <tr>
        <td class="right">
            <div class="sign-space" style="margin-top: 10px;">
                <div class="jabatan">Mengetahui,</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
            </div>
        </td>
        <td class="right">
            <div class="sign-space" style="margin-top: 10px;">
                <div class="jabatan">Mengesahkan,</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
            </div>
        </td>
    </tr>
</table>

{{-- TYPE: KETUA SAJA (1 kolom, kanan) --}}
@elseif($type === 'ketua')
<table class="signature">
    <tr>
        <td></td>
        <td class="left">
            <div class="place-date">
                Bangkinang, {{ now()->translatedFormat('d F Y') }}
            </div>
            <div class="sign-space">
                <div class="jabatan" style="margin-bottom: 60px;">Ketua HIMANIKKA,</div>
                <div class="line"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
            </div>
        </td>
    </tr>
</table>

{{-- TYPE: LPJ (Ketua + Sekretaris baris 1, Pembina + Rektor baris 2) --}}
@elseif($type === 'lpj')
<table class="signature">
    <tr>
        <td class="right">
            <div class="place-date">Bangkinang, {{ now()->translatedFormat('d F Y') }}</div>
            <div class="sign-space">
                <div class="jabatan">Ketua HIMANIKKA,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
            </div>
        </td>
        <td class="right">
            <div class="place-date">&nbsp;</div>
            <div class="sign-space">
                <div class="jabatan">Sekretaris,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Sekretaris HIMANIKKA</div>
            </div>
        </td>
    </tr>
</table>
<table class="signature">
    <tr>
        <td class="right">
            <div class="sign-space" style="margin-top: 10px;">
                <div class="jabatan">Mengetahui,</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
            </div>
        </td>
        <td class="right">
            <div class="sign-space" style="margin-top: 10px;">
                <div class="jabatan">Mengesahkan,</div>
                <div class="jabatan">Rektor Universitas Pahlawan Tuanku Tambusai,</div>
                <div class="line" style="margin-top: 50px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Rektor</div>
            </div>
        </td>
    </tr>
</table>

{{-- TYPE: SK (Ketua, lalu Pembina + Rektor) --}}
@elseif($type === 'sk')
<table class="signature">
    <tr>
        <td></td>
        <td class="right">
            <div class="place-date">
                Ditetapkan di : Bangkinang<br>
                Pada Tanggal  : {{ now()->translatedFormat('d F Y') }}
            </div>
            <div class="sign-space">
                <div class="jabatan" style="margin-bottom: 60px;">Ketua HIMANIKKA,</div>
                <div class="line"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Ketua HIMANIKKA</div>
            </div>
        </td>
    </tr>
</table>
<table class="signature" style="margin-top: 20px;">
    <tr>
        <td class="right">
            <div class="sign-space">
                <div class="jabatan">Mengetahui,</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
                <div class="line" style="margin-top: 60px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Pembina HIMANIKKA</div>
            </div>
        </td>
        <td class="right">
            <div class="sign-space">
                <div class="jabatan">Mengesahkan,</div>
                <div class="jabatan">Rektor Universitas Pahlawan Tuanku Tambusai,</div>
                <div class="line" style="margin-top: 60px;"></div>
                <div class="name">_________________</div>
                <div class="jabatan">Rektor</div>
            </div>
        </td>
    </tr>
</table>
@endif
