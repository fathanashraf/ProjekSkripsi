@extends('pembina.layouts.app')

@section('title', 'Struktur Organisasi HIMANIKKA')

@section('content')

<div x-data="{
    modalOpen: false,
    modalTitle: '',
    modalData: {}
}" class="space-y-6">

    {{-- Hero --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs ring-1 ring-white/20">
                    Struktur HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold">Struktur Organisasi</h1>
                <p class="mt-2 max-w-xl text-sm text-white/70">
                    Informasi susunan kepengurusan HIMANIKKA periode berjalan.
                </p>
            </div>

            <div class="rounded-2xl bg-white/10 px-6 py-4 backdrop-blur">
                <p class="text-sm text-white/70">Total Pengurus</p>
                <p class="mt-1 text-3xl font-bold">{{ $strukturs->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="card p-5">
            <div class="flex items-center gap-2">
                <div class="rounded-lg bg-blue-100 p-2 dark:bg-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-blue-600 dark:text-blue-400">
                        <path fill-rule="evenodd" d="M12 2.25a3 3 0 100 6 3 3 0 000-6zm0 2.25a.75.75 0 110 1.5.75.75 0 010-1.5zM7 8.25a3 3 0 014.5-.75.75.75 0 11.75 1.5v.75a3 3 0 013 3v7.5a3 3 0 01-3 3h-6a3 3 0 01-3-3v-7.5a3 3 0 013-3v-.75a.75.75 0 11.75-1.5A3 3 0 017 8.25z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Pengurus</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $strukturs->count() }}</p>
        </div>

        <div class="card p-5">
            <div class="flex items-center gap-2">
                <div class="rounded-lg bg-emerald-100 p-2 dark:bg-emerald-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-600 dark:text-emerald-400">
                        <path d="M21 12c0 1.047-.89 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v-2h-2c-1.103 0-2-.897-2-2v-2H7c-1.11 0-2-.897-2-2v-2H3c-1.11 0-2-.897-2-2V2.375c0-.825.75-1.375 1.5-1.375h16.5c.75 0 1.5.55 1.5 1.375V12zm-5-2V5h-2v5h2zm-4 0V5h-2v5h2zm-4 0V5H7v5h2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Jumlah Divisi</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $strukturs->pluck('devisi_id')->unique()->count() }}</p>
        </div>

        <div class="card p-5">
            <div class="flex items-center gap-2">
                <div class="rounded-lg bg-amber-100 p-2 dark:bg-amber-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-amber-600 dark:text-amber-400">
                        <path fill-rule="evenodd" d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a1 1 0 011 1v1a1 1 0 01-1 1h-1v1h1a1 1 0 011 1v1a1 1 0 01-1 1h-1v1.73c.6.34 1 .99 1 1.73a2 2 0 11-4 0c0-.74.4-1.39 1-1.73V13h-1a1 1 0 01-1-1v-1h-1a1 1 0 01-1-1v-1a1 1 0 011-1h1v-1h-1a1 1 0 01-1-1v-1a1 1 0 011-1h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM8.75 10.5a.75.75 0 000 1.5h5.5a.75.75 0 000-1.5h-5.5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Jabatan Aktif</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $strukturs->pluck('jabatan_id')->unique()->count() }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="card p-0 overflow-hidden">
        <div class="border-b px-6 py-5 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Data Kepengurusan</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Daftar anggota struktur organisasi HIMANIKKA.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950">
                    <tr class="text-left text-xs font-semibold uppercase text-slate-500">
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama</th>
                        <th class="px-6 py-4 font-semibold">Jabatan</th>
                        <th class="px-6 py-4 font-semibold">Divisi</th>
                        <th class="px-6 py-4 font-semibold">Posisi</th>
                        <th class="px-6 py-4 font-semibold">Periode</th>
                        <th class="px-6 py-4 font-semibold text-right">Detail</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($strukturs as $item)
                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Nama -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700 overflow-hidden">
                                        @if($item->foto)
                                            <img 
                                                src="{{ asset('storage/'.$item->foto) }}" 
                                                alt="{{ $item->user->name }}"
                                                class="h-full w-full object-cover"
                                            />
                                        @else
                                            <span>
                                                {{ strtoupper(substr($item->user->name, 0, 1)) ?? '-' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900 dark:text-white">
                                            {{ $item->user->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $item->user->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $item->jabatan->name_jabatan ?? '-' }}
                                </span>
                            </td>

                            <!-- Divisi -->
                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $item->devisi->name_devisi ?? '-' }}
                            </td>

                            <!-- Posisi -->
                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $item->posisi ?? '-' }}
                            </td>

                            <!-- Periode -->
                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $item->masa_jabatan ?? '-' }}
                            </td>

                            <!-- Detail -->
                            <td class="px-6 py-4 text-right">
                                <button
                                    type="button"
                                    @click="modalOpen = true; modalTitle = 'Detail Kepengurusan'; modalData = {
                                        nama: '{{ $item->user->name ?? '-' }}',
                                        email: '{{ $item->user->email ?? '-' }}',
                                        foto: '{{ $item->foto ? asset('storage/' . $item->foto) : '' }}',
                                        jabatan: '{{ $item->jabatan->name_jabatan ?? '-' }}',
                                        divisi: '{{ $item->devisi->name_devisi ?? '-' }}',
                                        periode: '{{ $item->masa_jabatan ?? '-' }}',
                                        posisi: '{{ $item->posisi ?? '-' }}',
                                        foto: '{{ $item->foto ? asset('storage/' . $item->foto) : '' }}'
                                    }"
                                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                >
                                    Lihat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12 text-slate-300 dark:text-slate-600">
                                        <path d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Belum ada struktur organisasi</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Data kepengurusan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail Kepengurusan -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
         @click.away="modalOpen = false"
         x-cloak>
        <div class="relative w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
             @click.away="modalOpen = false">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Detail Informasi Pengurus</p>
                </div>
                <button type="button" 
                        @click="modalOpen = false" 
                        class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-4">
                <!-- Foto -->
                <template x-if="modalData.foto">
                    <div class="mb-4 flex justify-center">
                        <img :src="modalData.foto" 
                             alt="Foto Pengurus" 
                             class="h-40 w-40 rounded-2xl object-cover shadow-lg">
                    </div>
                </template>

                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Nama:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.nama"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Email:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.email"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Jabatan:</span>
                    <p class="text-slate-700 dark:text-slate-300">
                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300" 
                              x-text="modalData.jabatan"></span>
                    </p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Divisi:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.divisi"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Posisi:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.posisi"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Periode:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.periode"></p>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                <button type="button" 
                        @click="modalOpen = false"
                        class="btn-secondary w-full justify-center">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

@endsection