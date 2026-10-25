@extends('pembina.layouts.app')

@section('title', 'Beranda Pembina')

@section('content')
<div class="space-y-6">

    {{-- Hero --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs ring-1 ring-white/20">
                    Dashboard Pembina HIMANIKKA
                </div>

                <h1 class="text-3xl font-bold sm:text-4xl">
                    Selamat Datang, Pembina
                </h1>

                <p class="mt-3 max-w-xl text-sm text-white/70 sm:text-base">
                    Halaman monitoring kegiatan HIMANIKKA. Pantau informasi acara,
                    kepengurusan, dan aktivitas organisasi secara mudah.
                </p>
            </div>

            <div class="rounded-2xl bg-white/10 p-5 backdrop-blur">
                <p class="text-sm text-white/70">Status Akses</p>
                <h3 class="mt-1 text-xl font-bold">Pembina</h3>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Acara</p>
                <div class="rounded-xl bg-blue-100 p-2 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $acaras ?? 0 }}</h2>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Pendaftaran</p>
                <div class="rounded-xl bg-emerald-100 p-2 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $pendaftaran ?? 0 }}</h2>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Pengurus Aktif</p>
                <div class="rounded-xl bg-purple-100 p-2 text-purple-600 dark:bg-purple-900/40 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 7.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $pengurus ?? 0 }}</h2>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Dokumentasi</p>
                <div class="rounded-xl bg-orange-100 p-2 text-orange-600 dark:bg-orange-900/40 dark:text-orange-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $dokumentasi ?? 0 }}</h2>
        </div>
    </div>

    {{-- Monitoring --}}
    <div class="card p-6">
        <h2 class="card-title text-lg">Monitoring HIMANIKKA</h2>
        <p class="card-subtitle text-sm">Akses cepat seluruh data organisasi</p>

        <div class="mt-6 space-y-3">
            <a href="{{ route('pembina.acara.index') }}" class="group flex items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-slate-700 dark:hover:bg-slate-800">
                <span class="font-medium text-slate-700 dark:text-slate-200">Data Acara</span>
                <span class="text-slate-400 transition group-hover:translate-x-1">→</span>
            </a>

            <a href="{{ route('pembina.struktur.index') }}" class="group flex items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-slate-700 dark:hover:bg-slate-800">
                <span class="font-medium text-slate-700 dark:text-slate-200">Struktur Organisasi</span>
                <span class="text-slate-400 transition group-hover:translate-x-1">→</span>
            </a>

            <a href="{{ route('pembina.laporan.index') }}" class="group flex items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-slate-700 dark:hover:bg-slate-800">
                <span class="font-medium text-slate-700 dark:text-slate-200">Laporan</span>
                <span class="text-slate-400 transition group-hover:translate-x-1">→</span>
            </a>

            <a href="{{ route('pembina.aspirasi.index') }}" class="group flex items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-slate-700 dark:hover:bg-slate-800">
                <span class="font-medium text-slate-700 dark:text-slate-200">Aspirasi</span>
                <span class="text-slate-400 transition group-hover:translate-x-1">→</span>
            </a>
        </div>
    </div>

    {{-- Grafik Keaktifan HIMANIKKA --}}
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Grafik Keaktifan HIMANIKKA</h2>
            <p class="card-subtitle text-sm">Statistik keaktifan acara, pengurus, keuangan, dan pendaftaran setiap bulan.</p>
        </div>

        <div class="h-80 px-4 py-4">
            <canvas id="aktifChart"></canvas>
        </div>
    </div>

</div>
@endsection

{{-- Chart.js --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('aktifChart');
    
    if (!ctx) {
        console.error('Canvas element not found');
        return;
    }

    // Data dari backend (real dari database)
    const chartData = @json($chartData);
    const chartLabels = @json($chartLabels);

    // Create Chart
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Acara',
                    data: chartData.acara || [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Pengurus',
                    data: chartData.pengurus || [],
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Keuangan',
                    data: chartData.keuangan || [],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Pendaftaran',
                    data: chartData.pendaftaran || [],
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 41, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(203, 213, 225, 0.3)',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    },
                    beginAtZero: true
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endpush

{{-- Styles untuk Chart --}}
@push('styles')
<style>
#aktifChart {
    width: 100%;
    height: 320px;
}
</style>
@endpush