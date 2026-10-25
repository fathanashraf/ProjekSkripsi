@extends('pembina.layouts.app')

@section('title', 'Monitoring Dokumentasi HIMANIKKA')

@section('content')
<div x-data="{
    modalOpen: false,
    modalMode: '',
    modalTitle: '',
    modalData: {}
}" class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-blue-900 to-cyan-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium ring-1 ring-white/20">
                    Dokumentasi Kegiatan HIMANIKKA
                </span>

                <h1 class="mt-3 text-3xl font-bold">
                    Monitoring Dokumentasi
                </h1>

                <p class="mt-2 text-sm text-white/80">
                    Monitoring seluruh dokumentasi kegiatan yang telah diunggah oleh pengurus HIMANIKKA.
                </p>
            </div>

            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                <p class="text-xs text-white/70">
                    Total Dokumentasi
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $dokumentasis->count() }}
                </h2>
            </div>

        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-3">

        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Total Dokumentasi
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $dokumentasis->count() }}
            </h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-blue-500">
                Total Acara
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $acaras->count() }}
            </h3>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card p-0 overflow-hidden">

        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Data Dokumentasi Kegiatan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Nama Dokumentasi</th>
                        <th class="px-6 py-4">Acara</th>
                        <th class="px-6 py-4">File</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                    @forelse($dokumentasis as $item)

                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-white">
                                    {{ $item->name_dokumentasi }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-700 dark:text-slate-300">
                                    {{ $item->acara->name_acara ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">

                                @if($item->file)

                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        File Tersedia
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/20 dark:text-red-300">
                                        Tidak Ada File
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="modalOpen = true; modalMode = 'info'; modalTitle = 'Detail Dokumentasi'; modalData = {name_dokumentasi: '{{ $item->name_dokumentasi }}', acara_id: '{{ $item->acara->name_acara ?? '-' }}', file: '{{ $item->file ? asset('storage/' . $item->file) : '' }}'}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                >
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-500 dark:text-slate-400">
                                Belum ada dokumentasi yang tersedia.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Modal Detail Dokumentasi --}}
    <div x-show="modalOpen"
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
         @click.away="modalOpen = false"
         x-cloak>
        <div class="relative w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Detail Dokumentasi Acara</p>
                </div>
                <button type="button" @click="modalOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <template x-if="modalData.file">
                    <div class="mb-4 rounded-2xl overflow-hidden shadow-lg">
                        <img :src="modalData.file" alt="Thumbnail Acara" class="w-full h-48 object-cover">
                    </div>
                </template>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Nama Dokumentasi: </span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.name_dokumentasi"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Acara: </span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.acara_id"></p>
                </div>
            </div>

            <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                <button type="button" @click="modalOpen = false"
                        class="btn-secondary w-full justify-center">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection