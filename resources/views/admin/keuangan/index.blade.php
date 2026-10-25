@extends('admin.layouts.app')

@section('title', 'Dashboard Management Keuangan')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-blue-900 via-indigo-900 to-purple-900 p-8 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="rounded-full bg-white/10 px-4 py-1 text-xs font-medium">
                    Dashboard Keuangan HIMANIKKA
                </span>

                <h1 class="mt-4 text-4xl font-bold">
                    Management Pembayaran
                </h1>

                <p class="mt-2 max-w-2xl text-white/70">
                    Kelola pembayaran peserta acara, metode pembayaran,
                    serta monitoring transaksi organisasi.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.export.keuangan.csv') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3.5 py-2 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/25">
                    📊 CSV
                </a>
                <a href="{{ route('admin.export.keuangan.xls') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3.5 py-2 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/25">
                    📗 Excel
                </a>
                <a href="{{ route('admin.export.keuangan.pdf') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3.5 py-2 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/25">
                    📕 PDF
                </a>
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

    {{-- GRID --}}
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
                            <th>Status Pembayaran</th>                                    <th>Metode</th>
                            <th>Pembayaran Via</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($keuangan as $item)
                            @php
                                $detailData = [
                                    'id' => $item->id,
                                    'user_name' => $item->user->name ?? ($item->pendaftaran->nama_pendaftar ?? '-'),
                                    'user_id' => $item->user_id ?? '-',
                                    'acara' => $item->acara->name_acara ?? '-',
                                    'acara_id' => $item->acara_id ?? '-',
                                    'biaya' => $item->biaya->nominal ?? 0,
                                    'status' => $item->pembayaran->status ?? '-',
                                    'metode' => $item->pembayaran->jenis ?? '-',
                                    'tanggal' => $item->pembayaran->created_at ?? $item->created_at ?? '-',
                                    'keterangan' => $item->keterangan ?? '-',
                                    'file' => $item->pembayaran->bukti_pembayaran ? asset('storage/' . $item->pembayaran->bukti_pembayaran) : '',
                                    'pembayaran_via' => $item->pembayaran->jenis === 'midtrans' ? 'Midtrans Online' : 'Manual',
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
                                    Rp {{ number_format($item->biaya->nominal ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if($item->pembayaran->status === 'lunas')
                                            bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @elseif($item->pembayaran->status === 'pending')
                                            bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ ucfirst($item->pembayaran->status ?? '-') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if($item->pembayaran->jenis === 'midtrans')
                                            bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300
                                        @elseif(in_array($item->pembayaran->jenis, ['cash', 'kredit']))
                                            bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ $item->pembayaran->jenis === 'midtrans' ? 'Midtrans Online' : ucfirst($item->pembayaran->jenis ?? '-') }}
                                    </span>
                                </td>

                                {{-- Pembayaran Via (untuk Midtrans) --}}
                                <td>
                                    @if($item->pembayaran->jenis === 'midtrans')
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400">Online</span>
                                    @elseif($item->pembayaran->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $item->pembayaran->bukti_pembayaran) }}" target="_blank" class="text-xs text-blue-600 underline">Lihat Bukti</a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    <button
                                        type="button"
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
                                    >
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada data pembayaran.
                                </td>
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
                @forelse($keuangan->take(5) as $item)
                    <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $item->user->name ?? '-' }}</p>
                        <p class="mt-1 text-sm text-slate-500">
                            Melakukan pembayaran untuk acara
                            <b>{{ $item->acara->name_acara ?? '-' }}</b>
                        </p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                        Belum ada aktivitas
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection