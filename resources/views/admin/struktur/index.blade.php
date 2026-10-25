@extends('admin.layouts.app')

@section('title', $title ?? 'Management Struktur Organisasi')
@section('pageTitle', 'Profil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Struktur Organisasi HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Management Struktur Organisasi
                </h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola susunan pengurus, jabatan, divisi, dan foto anggota secara terstruktur dalam satu halaman.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Devisi & Jabatan',
                        formAction: '{{ route('admin.jabatan.store') }}',
                        method: 'POST',
                        fields: @js([
                            [
                                'name' => 'name_jabatan',
                                'label' => 'Jabatan',
                                'type' => 'text',
                                'required' => true
                            ]
                        ]),
                        data: {
                            
                        }
                    })"
                    class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/20 hover:bg-white/20 transition"
                >
                    <span class="text-base">+</span>
                    Tambah Jabatan
                </button>

                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Devisi',
                        formAction: '{{ route('admin.devisi.store') }}',
                        method: 'POST',
                        fields: @js([
                            [
                                'name' => 'name_devisi',
                                'label' => 'Divisi',
                                'type' => 'text',
                                'required' => true
                            ]
                        ]),
                        data: {
                            user_id: '',
                            devisi_id: '',
                            jabatan_id: '',
                            posisi: '',
                            masa_jabatan: '',
                            foto: '',
                        }
                    })"
                    class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/20 hover:bg-white/20 transition"
                >
                    <span class="text-base">+</span>
                    Tambah Devisi
                </button>

                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Struktur',
                        formAction: '{{ route('admin.struktur.store') }}',
                        method: 'POST',
                        fields: @js([
                            [
                                'name' => 'user_id',
                                'label' => 'User',
                                'type' => 'select',
                                'options' => collect($users ?? [])->map(fn($u) => [
                                    'value' => $u->id,
                                    'label' => $u->name
                                ])->values()
                            ],
                            [
                                'name' => 'devisi_id',
                                'label' => 'Divisi',
                                'type' => 'select',
                                'options' => collect($devisis ?? [])->map(fn($d) => [
                                    'value' => $d->id,
                                    'label' => $d->name_devisi
                                ])->values()
                            ],
                            [
                                'name' => 'jabatan_id',
                                'label' => 'Jabatan',
                                'type' => 'select',
                                'options' => collect($jabatans ?? [])->map(fn($j) => [
                                    'value' => $j->id,
                                    'label' => $j->name_jabatan
                                ])->values()
                            ],
                            [
                                'name' => 'posisi',
                                'label' => 'Posisi',
                                'type' => 'select',
                                'options' => [
                                    [
                                        'value' => 'koordinator',
                                        'label' => 'Koordinator'
                                    ],
                                    [
                                        'value' => 'anggota',
                                        'label' => 'Anggota'
                                    ]
                                ]
                            ],
                            [
                                'name' => 'masa_jabatan',
                                'label' => 'Masa Jabatan',
                                'type' => 'text'
                            ],
                            [
                                'name' => 'foto',
                                'label' => 'Foto',
                                'type' => 'file'
                            ]
                        ]),
                        data: {
                            user_id: '',
                            devisi_id: '',
                            jabatan_id: '',
                            posisi: '',
                            masa_jabatan: '',
                            foto: '',
                        }
                    })"
                    class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/20 hover:bg-white/20 transition"
                >
                    <span class="text-base">+</span>
                    Tambah Struktur
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $total = $strukturs?->count() ?? 0;
        $posisiAktif = $strukturs?->where('posisi', 'anggota')->count() ?? 0;
        $divisiTerisi = $strukturs?->filter(fn($i) => filled($i->devisi_id))->count() ?? 0;
        $fotoTersedia = $strukturs?->filter(fn($i) => filled($i->foto))->count() ?? 0;
    @endphp

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Total Pengurus</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $total }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Posisi Aktif</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $posisiAktif }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Divisi Terisi</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $divisiTerisi }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500 dark:text-slate-400">Foto Tersedia</div>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $fotoTersedia }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Pengurus</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Data struktur organisasi yang tersimpan.</p>
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    Total: {{ $total }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Posisi</th>
                        <th class="px-6 py-4">Divisi</th>
                        <th class="px-6 py-4">Masa Jabatan</th>
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($strukturs as $struktur)
                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ strtoupper(substr($struktur->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-slate-100">
                                            {{ $struktur->user->name ?? $struktur->user_id ?? '-' }}
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">ID: {{ $struktur->user_id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                                    {{ $struktur->jabatan->name_jabatan ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                                    {{ $struktur->posisi ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-violet-50 px-3 py-1 text-xs font-medium text-violet-700 dark:bg-violet-950/40 dark:text-violet-300">
                                    {{ $struktur->devisi->name_devisi ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $struktur->masa_jabatan ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($struktur->foto)
                                    <img 
                                        class="h-10 w-10 rounded-full object-cover"
                                        src="{{ asset('storage/' . $struktur->foto) }}"
                                        alt="{{ $struktur->user->name ?? 'Foto' }}"
                                    >
                                @else
                                    <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
    <div class="flex justify-end gap-2">
        <!-- Tombol Detail -->
        <!-- Tombol Detail -->
<!-- Tombol Detail di Tabel -->
<button
    type="button"
    @click="$store.modal.open({
        mode: 'detail',
        title: 'Detail Struktur',
        detail: {
            name: '{{ $struktur->user->name ?? $struktur->user_id }}',
            jabatan_id: '{{ $struktur->jabatan->name_jabatan ?? $struktur->jabatan_id }}',
            devisi_id: '{{ $struktur->devisi->name_devisi ?? $struktur->devisi_id }}',
            foto: '{{ $struktur->foto ? asset('storage/' . $struktur->foto) : '' }}',
            masa_jabatan: '{{ $struktur->masa_jabatan }}',
        },
        fields: [
            {key: 'foto', label: 'Foto', type: 'image'},
            {key: 'name', label: 'Nama', type: 'text'},
            {key: 'jabatan_id', label: 'Jabatan', type: 'text'},
            {key: 'devisi_id', label: 'Divisi', type: 'text'},
            {key: 'masa_jabatan', label: 'Masa Jabatan', type: 'text'}
        ]
    })"
    class="inline-flex items-center gap-2 rounded-xl bg-blue-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-600"
>
    Detail
</button>

        <!-- Edit -->
        <button
            type="button"
            @click="$store.modal.open({
                mode: 'form',
                title: 'Edit Struktur',
                formAction: '{{ route('admin.struktur.update', $struktur->id) }}',
                method: 'POST',
                        fields: @js([
                            [
                                'name' => 'user_id',
                                'label' => 'User',
                                'type' => 'select',
                                'options' => collect($users ?? [])->map(fn($u) => [
                                    'value' => $u->id,
                                    'label' => $u->name
                                ])->values()
                            ],
                            [
                                'name' => 'devisi_id',
                                'label' => 'Divisi',
                                'type' => 'select',
                                'options' => collect($devisis ?? [])->map(fn($d) => [
                                    'value' => $d->id,
                                    'label' => $d->name_devisi
                                ])->values()
                            ],
                            [
                                'name' => 'jabatan_id',
                                'label' => 'Jabatan',
                                'type' => 'select',
                                'options' => collect($jabatans ?? [])->map(fn($j) => [
                                    'value' => $j->id,
                                    'label' => $j->name_jabatan
                                ])->values()
                            ],
                            [
                                'name' => 'posisi',
                                'label' => 'Posisi',
                                'type' => 'select',
                                'options' => $posisiOptions
                            ],
                            [
                                'name' => 'masa_jabatan',
                                'label' => 'Masa Jabatan',
                                'type' => 'text'
                            ],
                            [
                                'name' => 'foto',
                                'label' => 'Foto',
                                'type' => 'file'
                            ]
                        ]),
                        data: {
                            user_id: @js($struktur->user_id),
                            devisi_id: @js($struktur->devisi_id),
                            jabatan_id: @js($struktur->jabatan_id),
                            posisi: @js($struktur->posisi),
                            masa_jabatan: @js($struktur->masa_jabatan),
                            foto: '',
                        }
            })"
            class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600"
        >
            Edit
        </button>

        <!-- Hapus -->
        <button
            type="button"
            @click="$store.modal.open({
                mode: 'confirm',
                title: 'Hapus Struktur',
                message: 'Data struktur ini akan dihapus.',
                action: () => document.getElementById('delete-form-{{ $struktur->id }}').submit()
            })"
            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700"
        >
            Hapus
        </button>

        <form id="delete-form-{{ $struktur->id }}" action="{{ route('admin.struktur.destroy', $struktur->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">Belum ada data struktur</div>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Silakan klik tombol Tambah Struktur untuk menambahkan pengurus baru.
                                    </p>
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