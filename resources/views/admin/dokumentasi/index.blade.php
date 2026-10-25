@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Dokumentasi HIMANIKKA')
@section('pageTitle', 'Dokumentasi')

@section('content')
<div class="space-y-6">

    <!-- Hero -->
    <div
        class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <div
                    class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Manajemen Dokumentasi HIMANIKKA
                </div>

                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Dokumentasi HIMANIKKA
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-white/75 sm:text-base">
                    Kelola seluruh dokumentasi acara HIMANIKKA secara terpusat.
                </p>
            </div>

            <!-- Total -->
            <div
                class="rounded-2xl bg-white/10 px-4 py-3 text-sm text-white/85 ring-1 ring-white/15 backdrop-blur">

                <span class="block text-xs uppercase tracking-wider text-white/60">
                    Total Dokumentasi
                </span>

                <span class="mt-1 block text-2xl font-bold">
                    {{ $acaras->reduce(fn($total, $acara) => $total + $acara->dokumentasis->count(), 0) }}
                </span>
            </div>

            <!-- Button -->
            <button
                type="button"
                @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Dokumentasi Acara',
                        formAction: '{{ route('admin.dokumentasi.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',
                        fields: [
                            {
                                name: 'acara_id',
                                label: 'Acara',
                                type: 'select',
                                options: [
                                    { value: '', label: 'Pilih Acara' },
                                    @foreach ($acaras as $acara)
                                        { value: '{{ $acara->id }}', label: '{{ $acara->name_acara }}' },
                                    @endforeach
                                ]
                            },
                            {
                                name: 'name_dokumentasi',
                                label: 'Judul Dokumentasi',
                                type: 'text'
                            },
                            {
                                name: 'file[]',
                                label: 'File Dokumentasi',
                                type: 'file',
                                multiple: true
                            }
                        ],
                        data: {
                            
                        }
                    })"
                class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-100"
            >
                <span class="text-base">+</span>
                Tambah Dokumentasi Acara
            </button>

        </div>
    </div>

    <!-- List Acara -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse ($acaras as $acara)

            <div
                class="card p-0 overflow-hidden">

                <!-- Thumbnail -->
                <div class="relative h-56 overflow-hidden">

                    <img
                        src="{{ $acara->thumnail ? asset('storage/' . $acara->thumnail) : 'https://placehold.co/600x400' }}"
                        class="h-full w-full object-cover"
                        alt="{{ $acara->name_acara }}">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                    <div class="absolute bottom-4 left-4 right-4">
                        <h2 class="text-xl font-bold text-white">
                            {{ $acara->name_acara }}
                        </h2>

                        <p class="mt-1 text-sm text-white/80">
                            {{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }}
                        </p>
                    </div>

                </div>

                <!-- Content -->
                <div class="p-5">

                    <div class="mb-4 flex items-center justify-between">

                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                            {{ ucfirst($acara->tempat) }}
                        </span>

                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $acara->dokumentasis->count() }} File
                        </span>

                    </div>

                    <p class="text-sm leading-6 text-slate-600 dark:text-slate-300 line-clamp-3">
                        {{ $acara->keterangan ?? 'Tidak ada deskripsi acara.' }}
                    </p>

                    <!-- Dokumentasi -->
                    <div class="mt-6 space-y-3">

                        @forelse ($acara->dokumentasis as $dokumentasi)

                            <div
                                class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 12l-4 4m0 0l-4-4m4 4V3" />
                                        </svg>

                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $dokumentasi->name_dokumentasi ?? 'Dokumentasi #'.$loop->iteration }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ $dokumentasi->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                </div>

                                <!-- Action -->
                                <div class="flex items-center gap-2">

                                    <!-- Edit -->
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'form',
                                            title: 'Edit Dokumentasi',
                                            formAction: '{{ route('admin.dokumentasi.update', $dokumentasi->id) }}',
                                            method: 'POST',
                                            extraMethod: 'PUT',
                                            enctype: 'multipart/form-data',
                                            fields: [
                                                {
                                                    name: 'acara_id',
                                                    label: 'Acara',
                                                    type: 'select',
                                                    options: [
                                                        @foreach ($acaras as $option)
                                                            { value: '{{ $option->id }}', label: '{{ $option->name_acara }}' },
                                                        @endforeach
                                                    ]
                                                },
                                                { name: 'name_dokumentasi', label: 'Judul Dokumentasi', type: 'text', full: true },
                                                { name: 'file', label: 'Ganti File', type: 'file' }
                                            ],
                                            data: {
                                                acara_id: '{{ $dokumentasi->acara_id }}',
                                                name_dokumentasi: @js($dokumentasi->name_dokumentasi),
                                                file: ''
                                            }
                                        })"
                                        class="rounded-xl bg-amber-500 px-3 py-2 text-xs font-medium text-white hover:bg-amber-600"
                                    >
                                        Edit
                                    </button>

                                    <!-- View -->
                                    <a href="{{ asset('storage/' . $dokumentasi->file) }}"
                                        target="_blank"
                                        class="rounded-xl bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">

                                        Lihat
                                    </a>

                                    <!-- Download -->
                                    <a href="{{ asset('storage/' . $dokumentasi->file) }}"
                                        download
                                        class="rounded-xl bg-green-600 px-3 py-2 text-xs font-medium text-white hover:bg-green-700">

                                        Download
                                    </a>

                                    <!-- Delete -->
                                    <form
                                        action="{{ route('admin.dokumentasi.destroy', $dokumentasi->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-xl bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">

                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @empty

                            <div
                                class="rounded-2xl border border-dashed border-slate-300 p-6 text-center text-sm text-slate-500 dark:border-slate-700 dark:text-slate-400">

                                Belum ada dokumentasi untuk acara ini.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        @empty

            <div
                class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center dark:border-slate-700 dark:bg-slate-900">

                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Belum Ada Acara
                </h3>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Data acara HIMANIKKA belum tersedia.
                </p>

            </div>

        @endforelse

    </div>

</div>
@endsection