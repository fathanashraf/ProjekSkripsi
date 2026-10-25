@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Pendaftaran Acara')
@section('pageTitle', 'Pendaftaran')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Pendaftaran Acara HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Manajemen Pendaftaran
                </h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola data pendaftaran acara, status peserta, dan bukti pendaftaran dalam satu halaman.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Pendaftaran',
                        formAction: '{{ route('admin.pendaftaran.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',
                        fields: [
                            {name: 'name_pendaftar', label: 'Nama Pendaftar', type: 'text', required: true},
                            {name: 'user_id', label: 'User', type: 'select', options: @js($userOptions)},
                            {name: 'acaras_id', label: 'Acara', type: 'select', options: @js($acaraOptions)},
                            {name: 'status', label: 'Status', type: 'select', options: @js($statusOptions)},
                            {name: 'keterangan', label: 'Keterangan', type: 'textarea'},
                            {name: 'file', label: 'File', type: 'file'}
                        ],
                        data: {name_pendaftar: '', user_id: '', acaras_id: '', status: '', keterangan: '', file: ''}
                    })"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-100"
                >
                    <span class="text-base">+</span>
                    Tambah Pendaftaran
                </button>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Total Pendaftar</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $pendaftarans->total() ?? 0 }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Pending</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $pendaftarans->where('status', 'diajukan')->count() ?? 0 }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Diterima</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $pendaftarans->whereIn('status', ['diterima', 'dibayar'])->count() ?? 0 }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Ditolak</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $pendaftarans->where('status', 'ditolak')->count() ?? 0 }}</div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Pendaftaran</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Data pendaftaran acara yang tersimpan.</p>
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    Total: {{ $pendaftarans->total() ?? 0 }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Acara</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status Pendaftaran</th>
                        <th class="px-6 py-4">Pembayaran</th>
                        <th class="px-6 py-4">Bukti</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($pendaftarans ?? [] as $item)
                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                            {{-- User --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->user_id ? ($item->users?->name ?? '-') : ($item->nama_pendaftar ?? 'Guest') }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    ID: {{ $item->user_id ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->user_id ? ($item->users?->No_hp ?? '-') : ($item->NO_HP ?? '-') }}
                                </div>
                            </td>

                            {{-- Acara --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->acaras->name_acara ?? $item->acaras_id ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">ID: {{ $item->acaras_id ?? '-' }}</div>
                            </td>

                            <!-- tipe -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->acaras->tipe ?? $item->name_acara ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">Nama Acara: {{ $item->acaras->name_acara ?? '-' }}</div>
                            </td>

                            {{-- Status Pendaftaran --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                    @if($item->status === 'dibayar')
                                        bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300
                                    @elseif($item->status === 'diterima')
                                        bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
                                    @elseif($item->status === 'diajukan')
                                        bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300
                                    @elseif($item->status === 'ditolak')
                                        bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300
                                    @else
                                        bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                    @endif">
                                    {{ $item->status === 'dibayar' ? 'Lunas' : ucfirst($item->status ?? '-') }}
                                </span>
                            </td>

                            {{-- Pembayaran --}}
                            <td class="px-6 py-4">
                                @php $pby = $item->pembayaran; @endphp
                                @if($pby)
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if(in_array($pby->status, ['dibayar', 'lunas']))
                                            bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @elseif($pby->status === 'menunggu')
                                            bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300
                                        @elseif(in_array($pby->status, ['ditolak', 'kadaluarsa', 'dibatalkan']))
                                            bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $pby->status ?? '-')) }}
                                    </span>
                                    <div class="mt-1 text-[10px] text-slate-400">
                                        {{ $pby->jenis === 'midtrans' ? 'Midtrans' : ucfirst($pby->jenis) }}
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">Belum bayar</span>
                                @endif
                            </td>

                            {{-- Bukti --}}
                            <td class="px-6 py-4">
                                @if(!empty($item->file))
                                    <div class="flex items-center gap-3">
                                        <a href="{{ asset('storage/' . $item->file) }}" 
                                            target="_blank" 
                                            rel="noopener noreferrer"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            aria-label="Lihat bukti pendaftaran">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ asset('storage/' . $item->file) }}" 
                                            download
                                            class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300"
                                            aria-label="Download bukti pendaftaran">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-500 dark:text-slate-400">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Lihat Detail --}}
                                    <button
                                        type="button"
                                        @php $pembayaranDetail = $item->pembayaran; @endphp
                                    @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail Pendaftaran',
                                            detail: {
                                                name_pendaftar: '{{ $item->user_id ? ($item->users->name ?? '-') : ($item->nama_pendaftar ?? 'Guest') }}',
                                                email: '{{ $item->users->email ?? '-' }}',
                                                no_hp: '{{ $item->user_id ? ($item->users->No_hp ?? '-') : ($item->NO_HP ?? '-') }}',
                                                acara: '{{ $item->acaras->name_acara ?? $item->acaras_id ?? '-' }}',
                                                tipe_acara: '{{ $item->acaras->tipe ?? '-' }}',
                                                status: '{{ ucfirst($item->status ?? '-') }}',
                                                keterangan: '{{ $item->keterangan ?? '-' }}',
                                                file: '{{ $item->file ? asset('storage/' . $item->file) : '' }}',
                                                status_bayar: '{{ $pembayaranDetail ? ucfirst(str_replace('_', ' ', $pembayaranDetail->status)) : 'Belum bayar' }}',
                                                metode_bayar: '{{ $pembayaranDetail ? ($pembayaranDetail->jenis === 'midtrans' ? 'Midtrans Online' : ucfirst($pembayaranDetail->jenis)) : '-' }}',
                                                tanggal_daftar: '{{ $item->created_at->format('d M Y H:i') }}'
                                            },
                                            fields: [
                                                {key: 'name_pendaftar', label: 'Nama Pendaftar', type: 'text'},
                                                {key: 'email', label: 'Email', type: 'text'},
                                                {key: 'no_hp', label: 'No HP', type: 'text'},
                                                {key: 'acara', label: 'Acara', type: 'text'},
                                                {key: 'tipe_acara', label: 'Tipe Acara', type: 'text'},
                                                {key: 'status', label: 'Status Pendaftaran', type: 'text'},
                                                {key: 'status_bayar', label: 'Status Pembayaran', type: 'text'},
                                                {key: 'metode_bayar', label: 'Metode Bayar', type: 'text'},
                                                {key: 'tanggal_daftar', label: 'Tanggal Daftar', type: 'text'},
                                                {key: 'keterangan', label: 'Keterangan', type: 'textarea'},
                                                {key: 'file', label: 'Bukti Pendaftaran', type: 'link'}
                                            ]
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700"
                                    >
                                        Lihat Detail
                                    </button>

                                    {{-- Action Pending --}}
                                    @if($item->status === 'diajukan')
                                        <button
                                            type="button"
                                            @click="if(confirm('Konfirmasi Pendaftaran\n\nPendaftaran ini akan dikonfirmasi.\n\nYa | Batal')) { fetch('{{ route('admin.pendaftaran.approve', $item->id) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}}).then(() => location.reload()) }"
                                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700"
                                        >
                                            Konfirmasi
                                        </button>
                                        <button
                                            type="button"
                                            @click="if(confirm('Tolak Pendaftaran\n\nPendaftaran ini akan ditolak.\n\nYa | Batal')) { fetch('{{ route('admin.pendaftaran.reject', $item->id) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}}).then(() => location.reload()) }"
                                            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700"
                                        >
                                            Tolak
                                        </button>
                                    @elseif(in_array($item->status, ['diterima', 'dibayar'], true))
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $item->status === 'dibayar' ? 'Lunas' : 'Disetujui' }}
                                        </span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">Belum ada data pendaftaran</div>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Silakan klik tombol Tambah Pendaftaran untuk menambahkan data baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection