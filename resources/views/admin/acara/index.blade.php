@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Acara HIMANIKKA')
@section('pageTitle', 'Acara')

@section('content')
<div class="space-y-6">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Manajemen Acara HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Kelola Acara
                </h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola kegiatan, event internal, dan eksternal dengan rapi dalam satu halaman.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
    type="button"
    @click="$store.modal.open({
        mode: 'form',
        title: 'Tambah Acara',
        formAction: '{{ route('admin.acara.store') }}',
        method: 'POST',
        enctype: 'multipart/form-data',

        fields: [
            { name: 'name_acara', label: 'Nama Acara', type: 'text', required: true },
            { name: 'keterangan', label: 'Keterangan', type: 'textarea', required: false },
            { 
                name: 'tempat', 
                label: 'Tempat', 
                type: 'text', 
                required: false 
            },
            {
                name: 'user_id',
                label: 'Penanggung Jawab',
                type: 'select',
                required: true,
                options: [
                    { value: '', label: 'Pilih User' },
                    @foreach ($users as $user)
                        { value: '{{ $user->id }}', label: '{{ $user->name }}' },
                    @endforeach
                ]
            },
            { 
                name: 'tanggal', 
                label: 'Tanggal', 
                type: 'date', 
                required: true 
            },
            {
                name: 'syarat_id',
                label: 'Syarat Pendaftaran',
                type: 'select',
                required: true,
                options: [
                    { value: '', label: 'Pilih Syarat' },
                    @foreach ($syarats as $syarat)
                        { value: '{{ $syarat->id }}', label: '{{ $syarat->name_syarat }}' },
                    @endforeach
                ]
            },
            {
                name: 'biaya_id',
                label: 'Biaya Pendaftaran',
                type: 'select',
                required: true,
                options: [
                    { value: '', label: 'Pilih Biaya' },
                    @foreach ($biayas as $biaya)
                        { value: '{{ $biaya->id }}', label: 'Rp {{ number_format($biaya->nominal, 0, ',', '.') }}' },
                    @endforeach
                ]
            },
            { 
                name: 'thumnail', 
                label: 'Thumbnail', 
                type: 'file', 
                required: true 
            },
            {
                name: 'status',
                label: 'Status',
                type: 'select',
                required: true,
                options: [
                    { value: 'diajukan', label: 'Diajukan' },
                    { value: 'approved', label: 'Disetujui' },
                    { value: 'rejected', label: 'Ditolak' }
                ]
            },
            {
                name: 'tipe',
                label: 'Tipe',
                type: 'select',
                required: true,
                options: [
                    { value: '', label: 'Pilih Tipe' },
                    { value: 'internal', label: 'Internal' },
                    { value: 'eksternal', label: 'Eksternal' }
                ]
            },
        ],            data: {
                name_acara: '',
                keterangan: '',
                tempat: '',
                user_id: '',
                tanggal: '',
                syarat_id: '',
                biaya_id: '',
                thumnail: '',
                status: 'diajukan',
                tipe: '',
            }
    })"
>
    <div class="rounded-xl border border-teal/10 bg-white/10 p-3 backdrop-blur-md dark:bg-slate-900/40">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Tambah Acara
        </div>
    </div>
</button>

                <!-- tambah biaya -->
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Biaya',
                        formAction: '{{ route('admin.biaya.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',

                        fields: [
                            { name: 'name_biaya', label: 'Nama Pembiayaan', type: 'text', required: true },
                            { 
                                name: 'keterangan', 
                                label: 'Keterangan', 
                                type: 'textarea', 
                                required: false 
                            },
                            { 
                                name: 'nominal', 
                                label: 'Nominal (contoh: 500.000)', 
                                type: 'text', 
                                required: true 
                            },
                        ],

                        data: {}
                    })"
                >
                <div class="rounded-xl border border-white/10 bg-white/10 p-3 backdrop-blur-md dark:bg-slate-900/40">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tambah Biaya
                    </div>
                </div>
            </button>

            <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Biaya',
                        formAction: '{{ route('admin.syarat.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',

                        fields: [
                            

                            {   name: 'name_syarat', label: 'Syarat Untuk', type: 'text', required: true },
                            { 
                                name: 'kebutuhan',
                                label: 'Kebutuhan',
                                type: 'textarea',
                                required: false
                            },
                        ],

                        data: {}
                    })"
                >
                <div class="rounded-xl border border-white/10 bg-white/10 p-3 backdrop-blur-md dark:bg-slate-900/40">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tambah Syarat
                    </div>
                </div>
            </button>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Total Acara</div>
                    <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $stats['total_acara'] ?? 0 }}</div>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Internal</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">{{ $stats['internal'] ?? 0 }}</div>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Eksternal</div>
                    <div class="mt-2 text-3xl font-bold text-emerald-600">{{ $stats['eksternal'] ?? 0 }}</div>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Total Pendaftaran</div>
                    <div class="mt-2 text-3xl font-bold text-purple-600">{{ $stats['total_pendaftaran'] ?? 0 }}</div>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Acara</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Data acara yang tersimpan.</p>
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    Total: {{ $acaras->total() ?? 0 }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Nama Acara</th>
                        <th class="px-6 py-4">Penanggung Jawab</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pendaftar</th>
                        <th class="px-6 py-4">Biaya</th>
                        <th class="px-6 py-4">Thumbnail</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($acaras ?? [] as $item)
                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->name_acara ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">
                                    {{ $item->keterangan ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                <div class="font-medium">{{ $item->user->name ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                    {{ $item->tipe === 'internal'
                                        ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'
                                        : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' }}">
                                    {{ ucfirst($item->tipe ?? '-') }}
                                </span>
                            </td>

                            {{-- Status --}}
                            @php
                                $statusClasses = match ($item->status) {
                                    'approved', 'diterima' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400',
                                    'pending', 'diajukan' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                                    'rejected', 'ditolak' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400',
                                    default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                };
                                $statusLabel = match ($item->status) {
                                    'approved' => 'Disetujui',
                                    'diterima' => 'Diterima',
                                    'diajukan' => 'Diajukan',
                                    'pending' => 'Pending',
                                    'rejected' => 'Ditolak',
                                    'ditolak' => 'Ditolak',
                                    default => ucfirst($item->status ?? '-'),
                                };
                            @endphp
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $stats['total_pendaftar'][$item->id] ?? 0 }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if (!empty($item->thumnail))
                                    <img src="{{ Storage::url($item->thumnail) }}" alt="Thumbnail" class="h-12 w-12 rounded-2xl object-cover ring-2 ring-slate-200 dark:ring-slate-700">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400 dark:bg-slate-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </td>

                            {{-- Biaya --}}
                            <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-300">
                                @if ($item->biaya)
                                    Rp {{ number_format($item->biaya->nominal, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail Acara',
                                            detail: @js([
                                                'name_acara' => $item->name_acara ?? '-',
                                                'keterangan' => $item->keterangan ?? '-',
                                                'tempat' => $item->tempat ?? '-',
                                                'tipe' => ucfirst($item->tipe ?? '-'),
                                                'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-',
                                                'pj' => $item->user->name ?? '-',
                                                'syarat' => $item->syarat->name_syarat ?? '-',
                                                'biaya' => $item->biaya ? 'Rp ' . number_format($item->biaya->nominal, 0, ',', '.') : '-',
                                                'thumnail' => $item->thumnail ? Storage::url($item->thumnail) : '',
                                                'status' => $statusLabel ?? ucfirst($item->status ?? '-'),
                                                'jumlah_pendaftar' => ($stats['total_pendaftar'][$item->id] ?? 0) . ' Pendaftar',
                                            ]),
                                            fields: [
                                                {key: 'name_acara', label: 'Nama Acara', type: 'text'},
                                                {key: 'keterangan', label: 'Keterangan', type: 'textarea'},
                                                {key: 'tempat', label: 'Tempat', type: 'text'},
                                                {key: 'tipe', label: 'Tipe', type: 'text'},
                                                {key: 'tanggal', label: 'Tanggal', type: 'text'},
                                                {key: 'pj', label: 'Penanggung Jawab', type: 'text'},
                                                {key: 'syarat', label: 'Syarat', type: 'text'},
                                                {key: 'biaya', label: 'Biaya', type: 'text'},
                                                {key: 'status', label: 'Status', type: 'text'},
                                                {key: 'jumlah_pendaftar', label: 'Jumlah Pendaftar', type: 'text'},
                                                {key: 'thumnail', label: 'Thumbnail', type: 'image'},
                                            ]
                                        })"
                                        class="rounded-xl bg-blue-600 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>

                                    {{-- Generate PDF --}}
                                    @if (in_array($item->status, ['approved', 'diterima']))
                                    <div x-data="{ pdfOpen: false }" class="relative inline-block">
                                        <button
                                            type="button"
                                            @click="pdfOpen = !pdfOpen"
                                            @click.outside="pdfOpen = false"
                                            class="rounded-xl bg-emerald-600 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-emerald-700"
                                        >
                                            <svg class="h-3.5 w-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            PDF
                                        </button>
                                        <div x-show="pdfOpen"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-800">
                                            <div class="grid grid-cols-2 gap-2">
                                                <a href="{{ route('admin.export.acara.pdf', ['acara' => $item->id, 'jenis' => 'proposal']) }}" target="_blank"
                                                    class="flex flex-col items-center gap-1 rounded-xl bg-blue-50 p-3 text-center text-xs font-semibold text-blue-700 transition hover:bg-blue-100 hover:-translate-y-0.5 dark:bg-blue-950/40 dark:text-blue-300 dark:hover:bg-blue-950/60">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Proposal
                                                </a>
                                                <a href="{{ route('admin.export.acara.pdf', ['acara' => $item->id, 'jenis' => 'lpj']) }}" target="_blank"
                                                    class="flex flex-col items-center gap-1 rounded-xl bg-emerald-50 p-3 text-center text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 hover:-translate-y-0.5 dark:bg-emerald-950/40 dark:text-emerald-300 dark:hover:bg-emerald-950/60">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    LPJ
                                                </a>
                                                <a href="{{ route('admin.export.acara.pdf', ['acara' => $item->id, 'jenis' => 'sk']) }}" target="_blank"
                                                    class="flex flex-col items-center gap-1 rounded-xl bg-purple-50 p-3 text-center text-xs font-semibold text-purple-700 transition hover:bg-purple-100 hover:-translate-y-0.5 dark:bg-purple-950/40 dark:text-purple-300 dark:hover:bg-purple-950/60">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                                    </svg>
                                                    SK
                                                </a>
                                                <a href="{{ route('admin.export.acara.pdf', ['acara' => $item->id, 'jenis' => 'lengkap']) }}" target="_blank"
                                                    class="flex flex-col items-center gap-1 rounded-xl bg-amber-50 p-3 text-center text-xs font-semibold text-amber-700 transition hover:bg-amber-100 hover:-translate-y-0.5 dark:bg-amber-950/40 dark:text-amber-300 dark:hover:bg-amber-950/60">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                    </svg>
                                                    Lengkap
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'form',
                                            title: 'Edit Acara',
                                            formAction: '{{ route('admin.acara.update', $item->id) }}',
                                            method: 'POST',
                                            enctype: 'multipart/form-data',

                                            fields: [
                                                { name: 'name_acara', label: 'Nama Acara', type: 'text', required: true },
                                                { name: 'keterangan', label: 'Keterangan', type: 'textarea', required: false },
                                                { 
                                                    name: 'tempat', 
                                                    label: 'Tempat', 
                                                    type: 'text', 
                                                    required: false 
                                                },
                                                {
                                                    name: 'tipe',
                                                    label: 'Tipe',
                                                    type: 'select',
                                                    required: true,
                                                    options: [
                                                        { value: '', label: 'Pilih Tipe' },
                                                        { value: 'internal', label: 'Internal' },
                                                        { value: 'eksternal', label: 'Eksternal' }
                                                    ]
                                                },
                                                {
                                                    name: 'user_id',
                                                    label: 'Penanggung Jawab',
                                                    type: 'select',
                                                    required: true,
                                                    options: [
                                                        { value: '', label: 'Pilih User' },
                                                        @foreach ($users as $user)
                                                            { value: '{{ $user->id }}', label: '{{ $user->name }}' },
                                                        @endforeach
                                                    ]
                                                },
                                                { 
                                                    name: 'tanggal',
                                                    label: 'Tanggal',
                                                    type: 'date',
                                                    required: true
                                                },
                                                {
                                                    name: 'syarat_id',
                                                    label: 'Syarat Pendaftaran',
                                                    type: 'select',
                                                    required: true,
                                                    options: [
                                                        { value: '', label: 'Pilih Syarat' },
                                                        @foreach ($syarats as $syarat)
                                                            { value: '{{ $syarat->id }}', label: '{{ $syarat->name_syarat }}' },
                                                        @endforeach
                                                    ]
                                                },
                                                {
                                                    name: 'biaya_id',
                                                    label: 'Biaya Pendaftaran',
                                                    type: 'select',
                                                    required: true,
                                                    options: [
                                                        { value: '', label: 'Pilih Biaya' },
                                                        @foreach ($biayas as $biaya)
                                                            { value: '{{ $biaya->id }}', label: 'Rp {{ number_format($biaya->nominal, 0, ',', '.') }}' },
                                                        @endforeach
                                                    ]
                                                },
                                                { name: 'thumnail', label: 'Thumbnail (opsional jika tidak mengganti)', type: 'file', required: false }
                                            ],

                                            data: {
                                                name_acara: @js($item->name_acara ?? ''),
                                                keterangan: @js($item->keterangan ?? ''),
                                                tempat: @js($item->tempat ?? ''),
                                                tipe: @js($item->tipe ?? ''),
                                                user_id: @js($item->user_id ?? ''),
                                                tanggal: @js($item->tanggal ?? ''),
                                                syarat_id: @js($item->syarat_id ?? ''),
                                                biaya_id: @js($item->biaya_id ?? ''),
                                                thumnail: ''
                                            }
                                        })"
                                        class="rounded-xl bg-amber-500 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-amber-600"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'confirm',
                                            title: 'Hapus Acara',
                                            message: 'Data acara ini akan dihapus.',
                                            action: () => document.getElementById('delete-form-{{ $item->id }}').submit()
                                        })"
                                        class="rounded-xl bg-red-600 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-red-700"
                                    >
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.acara.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">Belum ada data acara</div>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Silakan klik tombol Tambah Acara untuk menambahkan acara baru.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($acaras->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                {{ $acaras->links() }}
            </div>
        @endif
    </div>
</div>

@endsection