<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $acara->name_acara ?? 'Acara' }} | HIMANIKKA</title>
    <style>
        @page { size: landscape; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ===== INFORMATIKA-THEMED BACKGROUND ===== */
        .cert-bg {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(160deg, #0b1121 0%, #1a2332 40%, #0f172a 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        /* Circuit grid pattern */
        .circuit-bg {
            position: absolute; inset: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(99, 102, 241, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.06) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* Circuit trace dots */
        .trace-dot {
            position: absolute; width: 4px; height: 4px; border-radius: 50%;
            background: rgba(99, 102, 241, 0.2);
            box-shadow: 0 0 6px rgba(99, 102, 241, 0.3);
        }
        .trace-dot:nth-child(1) { top: 8%; left: 5%; }
        .trace-dot:nth-child(2) { top: 15%; left: 92%; }
        .trace-dot:nth-child(3) { bottom: 12%; left: 8%; }
        .trace-dot:nth-child(4) { bottom: 20%; right: 6%; }
        .trace-dot:nth-child(5) { top: 45%; left: 3%; }
        .trace-dot:nth-child(6) { top: 60%; right: 4%; }

        /* ===== BORDERS ===== */
        .border-out {
            position: absolute; inset: 10px;
            border: 2px solid rgba(99, 102, 241, 0.4);
            border-radius: 20px; pointer-events: none;
        }
        .border-mid {
            position: absolute; inset: 18px;
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 14px; pointer-events: none;
        }
        .border-in {
            position: absolute; inset: 22px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 10px; pointer-events: none;
        }

        /* Glow accent corners */
        .corner-glow {
            position: absolute; width: 60px; height: 60px; pointer-events: none;
            background: radial-gradient(circle at center, rgba(99,102,241,0.15) 0%, transparent 70%);
        }
        .corner-glow.tl { top: 8px; left: 8px; }
        .corner-glow.tr { top: 8px; right: 8px; }
        .corner-glow.bl { bottom: 8px; left: 8px; }
        .corner-glow.br { bottom: 8px; right: 8px; }

        /* Corner brackets */
        .bracket { position: absolute; width: 35px; height: 35px; }
        .bracket-tl { top: 25px; left: 25px; border-top: 3px solid #6366f1; border-left: 3px solid #6366f1; border-radius: 6px 0 0 0; }
        .bracket-tr { top: 25px; right: 25px; border-top: 3px solid #6366f1; border-right: 3px solid #6366f1; border-radius: 0 6px 0 0; }
        .bracket-bl { bottom: 25px; left: 25px; border-bottom: 3px solid #6366f1; border-left: 3px solid #6366f1; border-radius: 0 0 0 6px; }
        .bracket-br { bottom: 25px; right: 25px; border-bottom: 3px solid #6366f1; border-right: 3px solid #6366f1; border-radius: 0 0 6px 0; }

        /* Tech accent line top */
        .tech-line {
            position: absolute; top: 42px; left: 50%; transform: translateX(-50%);
            width: 280px; height: 2px;
            background: linear-gradient(90deg, transparent, #6366f1, #818cf8, #6366f1, transparent);
        }

        /* ===== CONTENT ===== */
        .content {
            position: relative; z-index: 10;
            display: flex; flex-direction: column; align-items: center;
            justify-content: space-between;
            padding: 48px 55px 32px;
            width: 100%; height: 100%;
        }

        .top-section { text-align: center; }
        .mid-section { text-align: center; flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .bot-section { width: 100%; display: flex; align-items: flex-end; justify-content: space-between; padding: 0 15px; }

        .logo { height: 68px; width: auto; margin-bottom: 4px; }

        .org-name { font-size: 10px; letter-spacing: 4px; color: rgba(148,163,184,0.8); font-weight: 600; margin-bottom: 1px; text-transform: uppercase; }
        .uni-name { font-size: 8px; letter-spacing: 3px; color: rgba(148,163,184,0.5); text-transform: uppercase; }

        .cert-title {
            font-size: 30px; font-weight: 700;
            color: #818cf8; margin: 6px 0 4px;
            letter-spacing: 6px;
            text-shadow: 0 0 30px rgba(99,102,241,0.2);
        }

        .divider-tech {
            width: 160px; height: 1.5px;
            background: linear-gradient(90deg, transparent, #818cf8, transparent);
            margin: 4px auto;
        }

        .label-text { font-size: 12px; color: rgba(148,163,184,0.7); margin-bottom: 1px; }

        .participant {
            font-size: 28px; font-weight: 700;
            color: #f1f5f9; margin: 3px 0;
            letter-spacing: 2px;
        }

        .nim { font-size: 11px; color: rgba(148,163,184,0.6); margin-bottom: 3px; }

        .divider-silver {
            width: 220px; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(148,163,184,0.3), transparent);
            margin: 4px auto;
        }

        .desc {
            font-size: 12px;
            color: rgba(203,213,225,0.75);
            line-height: 1.7;
            max-width: 520px;
            margin: 0 auto;
        }
        .desc strong { color: #e2e8f0; font-weight: 700; }

        /* ===== BADGE / STAMP ===== */
        .stamp {
            width: 95px; height: 95px;
            border: 3.5px solid rgba(99, 102, 241, 0.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            opacity: 0.5; position: absolute;
            right: 50px; bottom: 28px;
            transform: rotate(-15deg);
            background: rgba(99, 102, 241, 0.05);
        }
        .stamp-inner { text-align: center; }
        .stamp-inner span {
            display: block;
            font-size: 8px; font-weight: 700;
            color: rgba(129, 140, 248, 0.7);
            text-transform: uppercase;
            letter-spacing: 2px; line-height: 1.3;
        }
        .stamp-star { font-size: 13px; margin-bottom: 1px; color: rgba(129, 140, 248, 0.8); }

        /* ===== SIGNATURE ===== */
        .sig-area { text-align: center; position: relative; }
        .sig-label { font-size: 11px; font-weight: 600; color: rgba(148,163,184,0.8); }
        .sig-line { width: 180px; border-top: 2px solid rgba(148,163,184,0.4); margin: 44px auto 0; }
        .sig-name { font-size: 12px; font-weight: 700; color: #e2e8f0; margin-top: 5px; }
        .sig-title { font-size: 9px; color: rgba(148,163,184,0.6); }

        .place-date { font-size: 11px; color: rgba(148,163,184,0.6); }

        /* Code decoration */
        .code-decoration {
            position: absolute; bottom: 28px; left: 50px;
            font-family: 'Courier New', monospace;
            font-size: 7px; color: rgba(99, 102, 241, 0.12);
            line-height: 1.6;
            letter-spacing: 1px;
            pointer-events: none;
        }

        /* ===== PRINT ===== */
        .no-print { display: flex !important; gap: 8px; }
        .print-btn, .close-btn {
            padding: 10px 24px; border: none; border-radius: 12px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .print-btn { background: #6366f1; color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
        .print-btn:hover { background: #4f46e5; transform: translateY(-1px); }
        .close-btn { background: rgba(255,255,255,0.1); color: #94a3b8; }
        .close-btn:hover { background: rgba(255,255,255,0.15); color: #e2e8f0; }

        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .stamp { opacity: 0.45; }
        }
    </style>
</head>
<body>
    <div class="cert-bg">
        {{-- Circuit grid --}}
        <div class="circuit-bg"></div>

        {{-- Trace dots --}}
        <div class="trace-dot"></div><div class="trace-dot"></div>
        <div class="trace-dot"></div><div class="trace-dot"></div>
        <div class="trace-dot"></div><div class="trace-dot"></div>

        {{-- Borders --}}
        <div class="border-out"></div><div class="border-mid"></div><div class="border-in"></div>

        {{-- Corner glows --}}
        <div class="corner-glow tl"></div><div class="corner-glow tr"></div>
        <div class="corner-glow bl"></div><div class="corner-glow br"></div>

        {{-- Corner brackets --}}
        <div class="bracket bracket-tl"></div><div class="bracket bracket-tr"></div>
        <div class="bracket bracket-bl"></div><div class="bracket bracket-br"></div>

        {{-- Tech line --}}
        <div class="tech-line"></div>

        {{-- Code decoration --}}
        <div class="code-decoration">
            &lt;!-- HIMANIKKA //--&gt;<br>
            &lt;informatics /&gt;&nbsp;&nbsp;&lt;passion /&gt;<br>
            &lt;?php echo "Sertifikat"; ?&gt;
        </div>

        {{-- Watermark --}}
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;opacity:0.03;">
            <span style="font-size:100px;font-weight:700;color:#818cf8;letter-spacing:15px;font-family:'Georgia',serif;">HIMANIKKA</span>
        </div>

        {{-- Content --}}
        <div class="content">
            {{-- TOP --}}
            <div class="top-section">
                <img src="{{ asset('assets/logoHima-.png') }}" alt="Logo HIMANIKKA" class="logo"
                     onerror="this.style.display='none'">
                <p class="org-name">Himpunan Mahasiswa Teknik Informatika</p>
                <p class="uni-name">Universitas Pahlawan Tuanku Tambusai</p>
            </div>

            {{-- MID --}}
            <div class="mid-section">
                <div class="cert-title">SERTIFIKAT</div>
                <div class="divider-tech"></div>
                <p class="label-text">Diberikan kepada</p>
                <h1 class="participant">
                    {{ $peserta->name ?? $pendaftaran->nama_pendaftar ?? 'Peserta' }}
                </h1>
                @if($peserta?->NIM)
                    <p class="nim">NIM. {{ $peserta->NIM }}</p>
                @endif
                <div class="divider-silver"></div>
                <p class="desc">
                    Telah berpartisipasi sebagai peserta dalam kegiatan<br>
                    <strong>{{ $acara->name_acara ?? 'Acara HIMANIKKA' }}</strong><br>
                    yang diselenggarakan pada<br>
                    <strong>{{ $acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('l, d F Y') : '-' }}</strong>
                    @if($acara->tempat)
                        <br>bertempat di <strong>{{ $acara->tempat }}</strong>
                    @endif
                </p>
            </div>

            {{-- BOTTOM --}}
            <div class="bot-section">
                <div class="place-date">
                    {{ $acara->tempat ?? 'Bangkinang' }}, {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="sig-area">
                    <div class="stamp">
                        <div class="stamp-inner">
                            <span class="stamp-star">★</span>
                            <span>HIMANIKKA</span>
                            <span>UPTT</span>
                        </div>
                    </div>
                    <p class="sig-label">Ketua HIMANIKKA</p>
                    <div class="sig-line"></div>
                    <p class="sig-name">{{ $acara->user?->name ?? '_________________' }}</p>
                    <p class="sig-title">Ketua Himpunan</p>
                </div>
            </div>
        </div>

        {{-- Print buttons --}}
        <div class="no-print" style="position:absolute;top:16px;right:16px;z-index:20;">
            <button onclick="window.print()" class="print-btn">🖨️ Cetak Sertifikat</button>
            <button onclick="window.close()" class="close-btn">✕ Tutup</button>
        </div>
    </div>

    @if(request('print'))
    <script>
        window.onload = function() { setTimeout(function() { window.print(); }, 500); };
    </script>
    @endif
</body>
</html>
