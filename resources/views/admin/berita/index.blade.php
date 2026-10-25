@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Berita HIMANIKKA')
@section('pageTitle', 'Berita')

@section('content')
<div class="space-y-6">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Manajemen Berita HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Kelola Berita</h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola judul berita, deskripsi, thumnail, dan file pendukung dalam satu halaman.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Berita',
                        formAction: '{{ route('admin.berita.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',
                        fields: [
                            {name: 'name_berita', label: 'Judul Berita', type: 'text', full: true},
                            {name: 'tanggal', label: 'Tanggal', type: 'date', full: true},
                            {name: 'user_id', label: 'User', type: 'select', options: @js($users->map(fn($u) => ['value' => $u->id, 'label' => $u->name]))},
                            {name: 'thumnail', label: 'Thumnail', type: 'file'},
                            {name: 'keterangan', label: 'Keterangan', type: 'textarea'}
                        ],
                        data: {name_berita: '', tanggal: '', user_id: {{ auth()->id() }}, thumnail: '', keterangan: ''}
                    })"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-100"
                >
                    <span class="text-base">+</span>
                    Tambah Berita
                </button>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Total Berita</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $beritas->total() ?? 0 }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Punya Thumnail</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $stats['with_thumbnail'] ?? 0 }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Penulis</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $stats['with_author'] ?? 0 }}</div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Berita</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Data berita yang tersimpan.</p>
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    Total: {{ $beritas->total() ?? 0 }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Thumnail</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($beritas ?? [] as $item)
                        @php
                            $detailBerita = [
                                'id' => $item->id,
                                'name_berita' => $item->name_berita ?? '-',
                                'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '',
                                'keterangan' => $item->keterangan ?? '-',
                                'user_id' => $item->user_id,
                                'user_name' => $item->user->name ?? '-',
                                'thumnail' => $item->thumnail ? asset('storage/' . $item->thumnail) : '',
                            ];
                        @endphp

                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $item->name_berita ?? '-' }}</div>
                                <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $item->keterangan ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $item->user->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if(!empty($item->thumnail))
                                    <img src="{{ asset('storage/' . $item->thumnail) }}" alt="Thumnail" class="h-12 w-12 rounded-2xl object-cover ring-2 ring-slate-200 dark:ring-slate-700">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400 dark:bg-slate-800">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail Berita',
                                            detail: @js($detailBerita),
                                            fields: [
                                                {key: 'name_berita', label: 'Judul Berita', type: 'text'},
                                                {key: 'tanggal', label: 'Tanggal', type: 'text'},
                                                {key: 'keterangan', label: 'Deskripsi', type: 'textarea'},
                                                {key: 'user_name', label: 'User', type: 'text'},
                                                {key: 'thumnail', label: 'Thumnail', type: 'image'}
                                            ]
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
                                    >
                                        Detail
                                    </button>

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'form',
                                            title: 'Edit Berita',
                                            formAction: '{{ route('admin.berita.update', $item->id) }}',
                                            method: 'POST',
                                            extraMethod: 'PUT',
                                            enctype: 'multipart/form-data',
                                            fields: [
                                                {name: 'name_berita', label: 'Judul Berita', type: 'text', full: true},
                                                {name: 'tanggal', label: 'Tanggal', type: 'date', full: true},
                                                {name: 'user_id', label: 'User', type: 'select', options: @js($users->map(fn($u) => ['value' => $u->id, 'label' => $u->name]))},
                                                {name: 'thumnail', label: 'Thumnail', type: 'file'},
                                                {name: 'keterangan', label: 'Keterangan', type: 'textarea'}
                                            ],
                                            data: {
                                                name_berita: @js($item->name_berita),
                                                tanggal: @js($item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : ''),
                                                user_id: @js($item->user_id),
                                                thumnail: '',
                                                keterangan: @js($item->keterangan)
                                            }
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-amber-700"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'confirm',
                                            title: 'Hapus Berita',
                                            message: 'Data berita ini akan dihapus.',
                                            action: () => document.getElementById('delete-form-{{ $item->id }}').submit()
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700"
                                    >
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">Belum ada data berita</div>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Silakan klik tombol Tambah Berita untuk menambahkan data baru.</p>
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