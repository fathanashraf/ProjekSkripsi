@extends('admin.layouts.app')
@section('title', 'Dashboard Monitoring - HIMANIKKA')

@push('styles')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:0.4} }
.live-dot { animation: pulse-dot 2s ease-in-out infinite; }
.animate-in { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
.animate-in:nth-child(1) { animation-delay: 0.03s; }
.animate-in:nth-child(2) { animation-delay: 0.06s; }
.animate-in:nth-child(3) { animation-delay: 0.09s; }
.animate-in:nth-child(4) { animation-delay: 0.12s; }
.animate-in:nth-child(5) { animation-delay: 0.15s; }
.animate-in:nth-child(6) { animation-delay: 0.18s; }
.animate-in:nth-child(7) { animation-delay: 0.21s; }
.animate-in:nth-child(8) { animation-delay: 0.24s; }

.custom-scroll::-webkit-scrollbar { width: 4px; }
.custom-scroll::-webkit-scrollbar-track { background: transparent; }
.custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.dark .custom-scroll::-webkit-scrollbar-thumb { background: #475569; }

.stat-card {
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
}
.dark .stat-card:hover {
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
}

.badge-status {
    display: inline-flex;
    align-items: center;
    padding: 2px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
}

@media (max-width: 480px) {
    .stat-card { padding: 12px !important; }
    .stat-card h3 { font-size: 1.25rem !important; }
}
</style>
@endpush

@section('content')
<div x-data="dashboardLive()" x-init="init()" class="space-y-5">

{{-- ===== HEADER ===== --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 p-6 sm:p-8 shadow-lg">
    <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white/5 blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-purple-400/10 blur-3xl"></div>

    <div class="relative">
        <div class="flex items-center gap-3 mb-2 flex-wrap">
            <div class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1">
                <span class="live-dot inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                <span class="text-[11px] font-semibold text-white/80">Monitoring Aktif</span>
            </div>
            <div class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1">
                <span class="text-[11px] font-medium text-white/70" x-text="currentDate"></span>
            </div>
            <div class="inline-flex items-center gap-1 rounded-full bg-white/10 px-3 py-1">
                <span class="text-[11px] font-medium text-white/70" x-text="currentTime"></span>
            </div>
        </div>

        <h1 class="text-xl sm:text-2xl font-bold text-white">
            Dashboard Monitoring, <span class="text-indigo-200">{{ auth()->user()->name }}</span> 🔍
        </h1>
        <p class="mt-1 text-sm text-indigo-200/80 max-w-xl">
            Pantau seluruh aktivitas organisasi HIMANIKKA. Klik kartu statistik untuk melihat data detail.
        </p>
    </div>

    {{-- Quick stats row --}}
    <div class="relative mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="rounded-xl bg-white/10 backdrop-blur p-3 sm:p-4">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-indigo-200/70">Pengurus</p>
            <p class="mt-1 text-xl sm:text-2xl font-bold text-white" x-text="totalPengurus.toLocaleString()"></p>
        </div>
        <div class="rounded-xl bg-white/10 backdrop-blur p-3 sm:p-4">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-indigo-200/70">Acara</p>
            <p class="mt-1 text-xl sm:text-2xl font-bold text-white" x-text="totalAcara.toLocaleString()"></p>
        </div>
        <div class="rounded-xl bg-white/10 backdrop-blur p-3 sm:p-4">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-indigo-200/70">Pengguna</p>
            <p class="mt-1 text-xl sm:text-2xl font-bold text-white" x-text="totalUser.toLocaleString()"></p>
        </div>
        <div class="rounded-xl bg-white/10 backdrop-blur p-3 sm:p-4">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-indigo-200/70">Notifikasi</p>
            <p class="mt-1 text-xl sm:text-2xl font-bold text-white" x-text="totalNotif.toLocaleString()"></p>
        </div>
    </div>
</div>

{{-- ===== STATISTICS CARDS (CLICKABLE → MODAL DETAIL) ===== --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-3">
    @php
        $statCards = [
            ['route'=>'admin.struktur.index','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'indigo','total'=>$total_pengurus,'label'=>'Pengurus','badge'=>null],
            ['route'=>'admin.acara.index','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'emerald','total'=>$total_acara,'label'=>'Acara','badge'=>$pending_acara > 0 ? $pending_acara.' pending' : null],
            ['route'=>'admin.berita.index','icon'=>'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z','color'=>'rose','total'=>$total_berita,'label'=>'Berita','badge'=>null],
            ['route'=>'admin.manajemen.index','icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z','color'=>'blue','total'=>$total_user,'label'=>'User','badge'=>null],
            ['route'=>'admin.pendaftaran.index','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','color'=>'amber','total'=>$total_pendaftaran,'label'=>'Pendaftaran','badge'=>$pending_pendaftaran > 0 ? $pending_pendaftaran.' baru' : null],
            ['route'=>'admin.aspirasi.index','icon'=>'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z','color'=>'purple','total'=>$total_aspirasi,'label'=>'Aspirasi','badge'=>$pending_aspirasi > 0 ? $pending_aspirasi.' baru' : null],
            ['route'=>'admin.laporan.index','icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','color'=>'cyan','total'=>$total_laporan,'label'=>'Laporan','badge'=>$pending_laporan > 0 ? $pending_laporan.' pending' : null],
            ['route'=>'admin.dokumentasi.index','icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'teal','total'=>$total_dokumentasi,'label'=>'Dokumentasi','badge'=>null],
        ];
        $colorClasses = [
            'indigo' => ['bg'=>'bg-indigo-50 dark:bg-indigo-900/30','text'=>'text-indigo-600 dark:text-indigo-400'],
            'emerald' => ['bg'=>'bg-emerald-50 dark:bg-emerald-900/30','text'=>'text-emerald-600 dark:text-emerald-400'],
            'rose' => ['bg'=>'bg-rose-50 dark:bg-rose-900/30','text'=>'text-rose-600 dark:text-rose-400'],
            'blue' => ['bg'=>'bg-blue-50 dark:bg-blue-900/30','text'=>'text-blue-600 dark:text-blue-400'],
            'amber' => ['bg'=>'bg-amber-50 dark:bg-amber-900/30','text'=>'text-amber-600 dark:text-amber-400'],
            'purple' => ['bg'=>'bg-purple-50 dark:bg-purple-900/30','text'=>'text-purple-600 dark:text-purple-400'],
            'cyan' => ['bg'=>'bg-cyan-50 dark:bg-cyan-900/30','text'=>'text-cyan-600 dark:text-cyan-400'],
            'teal' => ['bg'=>'bg-teal-50 dark:bg-teal-900/30','text'=>'text-teal-600 dark:text-teal-400'],
        ];
    @endphp
    @foreach($statCards as $card)
    <a href="{{ route($card['route']) }}" class="animate-in stat-card relative rounded-xl bg-white p-4 shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50">
        <div class="flex items-start justify-between mb-2.5">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg {{ $colorClasses[$card['color']]['bg'] }}">
                <svg class="h-[18px] w-[18px] {{ $colorClasses[$card['color']]['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
            @if($card['badge'])
                <span class="badge-status bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">{{ $card['badge'] }}</span>
            @endif
        </div>
        <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $card['total'] }}</h3>
        <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-0.5">{{ $card['label'] }}</p>
    </a>
    @endforeach
</div>

{{-- ===== CHART + ACTIVITY FEED ===== --}}
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Chart --}}
    <div class="animate-in lg:col-span-2 rounded-xl bg-white shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-700/50">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">📊 Aktivitas Organisasi</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Data 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-sm bg-indigo-500"></span> Acara</span>
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-sm bg-emerald-500"></span> Pendaftaran</span>
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-sm bg-rose-500"></span> Aspirasi</span>
            </div>
        </div>
        <div class="p-4 sm:p-5">
            <div id="activityChart" class="h-48 sm:h-56 md:h-72"></div>
        </div>
    </div>

    {{-- Activity feed --}}
    <div class="animate-in rounded-xl bg-white shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-700/50">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">🔔 Aktivitas Terbaru</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update terbaru</p>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                <span class="live-dot inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span> LIVE
            </span>
        </div>
        <div class="max-h-[340px] overflow-y-auto custom-scroll">
            @forelse($recent_notifications as $notif)
            @php $ncMap = ['amber'=>'#f59e0b','rose'=>'#f43f5e','emerald'=>'#10b981','blue'=>'#3b82f6']; $nc = $ncMap[$notif['color']] ?? '#6366f1'; @endphp
            <div class="flex items-start gap-3 px-5 py-3.5 border-b border-slate-50 last:border-b-0 transition hover:bg-slate-50 dark:border-slate-700/30 dark:hover:bg-slate-700/30">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg" style="background:{{ $nc }}15">
                    <svg class="h-4 w-4" style="color:{{ $nc }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $notif['icon'] }}"/></svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $notif['title'] }}</p>
                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 truncate">{{ $notif['desc'] }}</p>
                    <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">{{ $notif['time'] }}</p>
                </div>
                <span class="badge-status flex-shrink-0 {{ in_array($notif['status'],['pending','diajukan']) ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' }}">{{ ucfirst($notif['status']) }}</span>
            </div>
            @empty
            <div class="flex flex-col items-center px-6 py-14 text-center">
                <svg class="mb-3 h-10 w-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Belum ada aktivitas</p>
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Aktivitas akan muncul di sini</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ===== ACARA + STRUKTUR DIVISI ===== --}}
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Acara list --}}
    <div class="animate-in lg:col-span-2 rounded-xl bg-white shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-700/50">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">📅 Acara & Kegiatan Terbaru</h3>
            <a href="{{ route('admin.acara.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
            @forelse($recent_acaras as $acara)
            <div class="flex items-center gap-3 sm:gap-4 px-5 py-3.5 transition hover:bg-slate-50 dark:hover:bg-slate-700/30">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-sm font-bold text-white shadow-sm">{{ substr($acara->name_acara??'A',0,2) }}</div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $acara->name_acara ?? 'Tanpa Nama' }}</p>
                    <div class="mt-0.5 flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 text-xs text-slate-500 dark:text-slate-400">
                        <span>🗓 {{ $acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-' }}</span>
                        <span class="hidden sm:inline text-slate-300 dark:text-slate-600">•</span>
                        <span class="truncate">📍 {{ $acara->tempat ?? '-' }}</span>
                    </div>
                </div>
                <span class="badge-status flex-shrink-0 {{ $acara->status==='approved' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : ($acara->status==='pending' ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400' : 'bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400') }}">{{ $acara->status ?? '-' }}</span>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada acara tersedia.</div>
            @endforelse
        </div>
    </div>

    {{-- Struktur divisi --}}
    <div class="animate-in rounded-xl bg-white shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700/50">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">👥 Struktur Divisi</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $total_pengurus }} total anggota</p>
        </div>
        <div class="p-5 space-y-4">
            @forelse($strukturByDevisi as $divisi)
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $divisi['name'] }}</span>
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $divisi['total'] }} orang</span>
                </div>
                <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">
                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-700" style="width:{{ $total_pengurus>0?($divisi['total']/max($total_pengurus,1))*100:0 }}%"></div>
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data struktur.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ===== ROLE DISTRIBUTION ===== --}}
<div class="animate-in rounded-xl bg-white shadow-sm border border-slate-200/60 dark:bg-slate-800/80 dark:border-slate-700/50 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700/50">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">👤 Distribusi Role Pengguna</h3>
    </div>
    <div class="p-5">
        @php $totalRole = array_sum($roleDistribution['data']); @endphp
        @foreach($roleDistribution['label'] as $idx => $label)
            @php $pct = $totalRole > 0 ? round(($roleDistribution['data'][$idx] / $totalRole) * 100) : 0; @endphp
            <div class="mb-4 last:mb-0">
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-3 w-3 rounded-full" style="background:{{ $roleDistribution['colors'][$idx] }}"></span>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $roleDistribution['data'][$idx] }} ({{ $pct }}%)</span>
                </div>
                <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">
                    <div class="h-full rounded-full transition-all duration-1000" style="width:{{ $pct }}%;background:{{ $roleDistribution['colors'][$idx] }}"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ===== FOOTER ===== --}}
<div class="animate-in flex items-center justify-between gap-3 pt-2 pb-1 text-xs text-slate-400 dark:text-slate-600">
    <div class="flex items-center gap-2 sm:gap-4">
        <span class="flex items-center gap-1"><span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Sistem Berjalan</span>
        <span class="hidden sm:inline">·</span>
        <span class="hidden sm:inline">HIMANIKKA</span>
        <span class="hidden sm:inline">·</span>
        <span class="hidden sm:inline">UPTT</span>
    </div>
    <div>Dashboard v2.0</div>
</div>

</div>

@push('scripts')
<script>
function dashboardLive() {
    return {
        currentDate: '',
        currentTime: '',
        clockInterval: null,
        totalPengurus: {{ $total_pengurus }},
        totalAcara: {{ $total_acara }},
        totalUser: {{ $total_user }},
        totalNotif: {{ $total_notifications }},

        init() {
            this.updateClock()
            this.clockInterval = setInterval(() => this.updateClock(), 1000)
            this.$nextTick(() => this.initChart())
        },

        updateClock() {
            const n = new Date()
            this.currentDate = n.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
            this.currentTime = n.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
        },

        initChart() {
            const el = document.querySelector('#activityChart')
            if (!el || typeof ApexCharts === 'undefined') return

            const isDark = document.documentElement.classList.contains('dark')
            const cd = @json($chartData);
            const isMobile = window.innerWidth < 480
            const isTablet = window.innerWidth < 768
            const chartH = isMobile ? 200 : isTablet ? 240 : 290

            new ApexCharts(el, {
                chart: { type: 'area', height: chartH, toolbar: { show: false }, foreColor: isDark ? '#94a3b8' : '#64748b', animations: { enabled: true, easing: 'easeinout', speed: 800 }, background: 'transparent' },
                series: [
                    { name: 'Acara', data: [...(cd.acara || [])] },
                    { name: 'Pendaftaran', data: [...(cd.pendaftaran || [])] },
                    { name: 'Aspirasi', data: [...(cd.aspirasi || [])] }
                ],
                stroke: { curve: 'smooth', width: 2.5 },
                colors: ['#6366f1', '#10b981', '#f43f5e'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 90, 100] } },
                dataLabels: { enabled: false },
                grid: { borderColor: isDark ? '#334155' : '#e2e8f0', strokeDashArray: 4 },
                xaxis: { categories: cd.labels || [], axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: isDark ? '#94a3b8' : '#64748b', fontSize: '11px' } } },
                yaxis: { labels: { formatter: v => Math.round(v), style: { colors: isDark ? '#94a3b8' : '#64748b', fontSize: '11px' } }, min: 0 },
                tooltip: { theme: isDark ? 'dark' : 'light', x: { show: true } },
                legend: { position: 'top', horizontalAlign: 'right', fontSize: '12px', markers: { width: 8, height: 8, radius: 4 } }
            }).render()
        }
    }
}
</script>
@endpush
@endsection