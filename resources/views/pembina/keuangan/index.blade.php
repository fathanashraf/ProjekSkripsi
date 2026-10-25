@extends('pembina.layouts.app')

@section('title', 'Monitoring Keuangan HIMANIKKA')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-blue-900 via-indigo-900 to-purple-900 p-8 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="rounded-full bg-white/10 px-4 py-1 text-xs font-medium">
                    Monitoring Keuangan HIMANIKKA
                </span>
                <h1 class="mt-4 text-4xl font-bold">Laporan Keuangan</h1>
                <p class="mt-2 max-w-2xl text-white/70">
                    Monitoring pemasukan, pengeluaran, pembayaran peserta acara, serta transaksi organisasi.
                </p>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="card p-6">
            <p class="text-sm text-slate-500">Total Pembayaran</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalPembayaran ?? 0 }}</h2>
        </div>
        <div class="card p-6">
            <p class="text-sm text-slate-500">Total Peserta Membayar</p>
            <h2 class="mt-2 text-3xl font-bold text-green-600">{{ $totalPeserta ?? 0 }}</h2>
        </div>
        <div class="card p-6">
            <p class="text-sm text-slate-500">Total Acara</p>
            <h2 class="mt-2 text-3xl font-bold text-blue-600">{{ $totalAcara ?? 0 }}</h2>
        </div>
        <div class="card p-6">
            <p class="text-sm text-slate-500">Metode Pembayaran</p>
            <h2 class="mt-2 text-3xl font-bold text-purple-600">{{ $totalMetode ?? 0 }}</h2>
        </div>
        <div class="card p-6">
            <p class="text-sm text-slate-500">Midtrans</p>
            <h2 class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalMidtrans ?? 0 }}</h2>
        </div>
        <div class="card p-6">
            <p class="text-sm text-slate-500">Manual (Cash/Transfer)</p>
            <h2 class="mt-2 text-3xl font-bold text-amber-600">{{ $totalManual ?? 0 }}</h2>
        </div>
    </div>

    {{-- GRAFIK --}}
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Grafik Pemasukan & Pengeluaran per Bulan</h2>
            <p class="text-sm text-slate-500">Total pemasukan dan pengeluaran setiap bulan (Jan - Des).</p>
        </div>
        <div class="h-80 px-4 py-4">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>

    {{-- GRID: Tabel + Aktivitas --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- PEMBAYARAN TERBARU --}}
        <div class="lg:col-span-2 rounded-3xl bg-white p-6 shadow-sm dark:bg-slate-900">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Pembayaran Terbaru</h2>
                    <p class="text-sm text-slate-500">Data pembayaran terbaru peserta</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-sm text-slate-500 dark:border-slate-800">
                            <th class="py-4">Pendaftar</th>
                            <th>Acara</th>
                            <th>Biaya</th>
                            <th>Status Pembayaran</th>
                            <th>Metode</th>
                            <th>Pembayaran Via</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($keuangans as $item)
                            @php
                                $pby = $item->pembayaran;
                                $detailData = [
                                    'id' => $item->id,
                                    'user_name' => $item->user->name ?? ($item->pendaftaran->nama_pendaftar ?? '-'),
                                    'user_id' => $item->user_id ?? '-',
                                    'acara' => $item->acara->name_acara ?? '-',
                                    'acara_id' => $item->acara_id ?? '-',
                                    'biaya' => 'Rp ' . number_format($item->biaya->nominal ?? $item->nominal ?? 0, 0, ',', '.'),
                                    'status' => $pby->status ?? '-',
                                    'metode' => $pby->jenis ?? '-',
                                    'tanggal' => $item->created_at->format('d M Y'),
                                    'keterangan' => $item->keterangan ?? '-',
                                    'file' => $pby->bukti_pembayaran ? asset('storage/' . $pby->bukti_pembayaran) : '',
                                    'pembayaran_via' => ($pby->jenis ?? '') === 'midtrans' ? 'Midtrans Online' : 'Manual',
                                ];
                            @endphp

                            <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="py-4">
                                    <div class="font-semibold text-slate-900 dark:text-white">
                                        {{ $item->user->name ?? ($item->pendaftaran->nama_pendaftar ?? '-') }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">ID: {{ $item->user_id ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="font-medium text-slate-900 dark:text-white">{{ $item->acara->name_acara ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">ID: {{ $item->acara_id ?? '-' }}</div>
                                </td>
                                <td class="font-semibold text-slate-900 dark:text-white">
                                    Rp {{ number_format($item->biaya->nominal ?? $item->nominal ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if(($pby->status ?? '') === 'lunas')
                                            bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @elseif(($pby->status ?? '') === 'pending' || ($pby->status ?? '') === 'menunggu')
                                            bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $pby->status ?? '-')) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if(($pby->jenis ?? '') === 'midtrans')
                                            bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300
                                        @elseif(in_array($pby->jenis ?? '', ['cash', 'kredit']))
                                            bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ ($pby->jenis ?? '') === 'midtrans' ? 'Midtrans Online' : ucfirst($pby->jenis ?? '-') }}
                                    </span>
                                </td>
                                <td>
                                    @if(($pby->jenis ?? '') === 'midtrans')
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400">Online</span>
                                    @elseif($pby && $pby->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $pby->bukti_pembayaran) }}" target="_blank" class="text-xs text-blue-600 underline">Lihat Bukti</a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <button type="button"
                                        @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail Pembayaran',
                                            detail: @js($detailData),
                                            fields: [
                                                {key: 'user_name', label: 'Pendaftar', type: 'text'},
                                                {key: 'user_id', label: 'User ID', type: 'text'},
                                                {key: 'acara', label: 'Acara', type: 'text'},
                                                {key: 'acara_id', label: 'Acara ID', type: 'text'},
                                                {key: 'biaya', label: 'Biaya', type: 'text'},
                                                {key: 'status', label: 'Status Pembayaran', type: 'text'},
                                                {key: 'metode', label: 'Metode Pembayaran', type: 'text'},
                                                {key: 'tanggal', label: 'Tanggal Bayar', type: 'text'},
                                                {key: 'keterangan', label: 'Keterangan', type: 'textarea'},
                                                {key: 'file', label: 'Bukti Pembayaran', type: 'link'},
                                                {key: 'pembayaran_via', label: 'Via', type: 'text'}
                                            ]
                                        })"
                                        class="rounded-xl bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700"
                                    >Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">Belum ada data pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- AKTIVITAS --}}
        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Aktivitas Sistem</h2>
            <div class="mt-5 space-y-4">
                @forelse($keuangans->take(5) as $item)
                    <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->user->name ?? '-' }}</p>
                        <p class="mt-1 text-sm text-slate-500">
                            Melakukan pembayaran untuk acara
                            <b>{{ $item->acara->name_acara ?? '-' }}</b>
                        </p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">Belum ada aktivitas</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('keuanganChart');
    if (!ctx) { console.error('Canvas not found'); return; }

    const chartData = @json($chartData ?? []);
    const months = chartData.labels ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const pemasukanData = chartData.pemasukan ?? [];
    const pengeluaranData = chartData.pengeluaran ?? [];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                { label: 'Pemasukan', data: pemasukanData, backgroundColor: 'rgba(16, 185, 129, 0.7)', borderColor: '#10b981', borderWidth: 2, borderRadius: 8, borderSkipped: false },
                { label: 'Pengeluaran', data: pengeluaranData, backgroundColor: 'rgba(239, 68, 68, 0.7)', borderColor: '#ef4444', borderWidth: 2, borderRadius: 8, borderSkipped: false }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 15, font: { size: 12, family: "'Inter', sans-serif" } } },
                title: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 41, 0.9)', titleColor: '#fff', bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)', borderWidth: 1, padding: 12, cornerRadius: 8, displayColors: true,
                    callbacks: { label: function(ctx) { let l = ctx.dataset.label || ''; if (l) l += ': '; if (ctx.parsed.y !== null) l += 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'); return l; } }
                }
            },
            scales: {
                x: { grid: { display: false, drawBorder: false }, ticks: { color: '#64748b', font: { size: 13, weight: '500' } } },
                y: { grid: { color: 'rgba(203, 213, 225, 0.3)', borderDash: [5, 5] }, ticks: { color: '#64748b', font: { size: 11 }, callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } }, beginAtZero: true }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>#keuanganChart { width: 100%; height: 320px; }</style>
@endpush

@endsection
