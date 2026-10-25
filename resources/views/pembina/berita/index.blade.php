@extends('pembina.layouts.app')

@section('title', 'Monitoring Berita HIMANIKKA')

@section('content')

<div x-data="{
    modalOpen: false,
    modalTitle: '',
    modalData: {}
}" class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-4">

            <div class="inline-flex w-fit items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium">
                Monitoring Berita
            </div>

            <div>
                <h1 class="text-3xl font-bold">
                    Berita HIMANIKKA
                </h1>

                <p class="mt-2 text-sm text-white/70">
                    Monitoring seluruh berita yang telah dipublikasikan oleh pengurus HIMANIKKA.
                </p>
            </div>

        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-3">

        <div class="card p-5">
            <div class="text-sm text-slate-500">
                Total Berita
            </div>

            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $beritas->total() }}
            </div>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="card p-0 overflow-hidden">

        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Daftar Berita
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Semua berita yang telah dipublikasikan.
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">

                {{-- Header --}}
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Thumbnail</th>
                        <th class="px-6 py-4">Judul Berita</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($beritas as $berita)

                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">

                            <td class="px-6 py-4">
                                <img
                                    src="{{ $berita->thumnail ? asset('storage/' . $berita->thumnail) : 'https://placehold.co/100x100' }}"
                                    alt="{{ $berita->name_berita }}"
                                    class="h-16 w-16 rounded-2xl object-cover shadow"
                                >
                            </td>

                            <td class="px-6 py-4">
                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    {{ $berita->name_berita ?? '-' }}
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $berita->tanggal ? \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') : '-' }}

                                    ID #{{ $berita->id }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $berita->keterangan ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600">
                                        {{ strtoupper(substr($berita->user->name ?? 'U',0,1)) }}
                                    </div>

                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-white">
                                            {{ $berita->user->name ?? '-' }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            Penulis
                                        </div>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <button
                                        type="button"
                                        @click="modalOpen = true; modalTitle = 'Detail Berita'; modalData = {
                                            name_berita: @js($berita->name_berita),
                                            keterangan: @js($berita->keterangan),
                                            tanggal: @js($berita->tanggal ? \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') : '-'),
                                            user_name: @js($berita->user->name ?? '-'),
                                            thumnail: @js($berita->thumnail ? asset('storage/' . $berita->thumnail) : ''),
                                            id: @js('#'.$berita->id)
                                        }"
                                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">
                                    📰
                                </div>

                                <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">
                                    Belum Ada Berita
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Data berita yang dipublikasikan akan muncul di sini.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- Modal Detail Berita -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
         @click.away="modalOpen = false"
         x-cloak>
        <div class="relative w-full max-w-4xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
             @click.away="modalOpen = false">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Detail Informasi Berita</p>
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
                <!-- Thumbnail Image -->
                <template x-if="modalData.thumnail">
                    <div class="mb-4 rounded-2xl overflow-hidden shadow-lg">
                        <img :src="modalData.thumnail" 
                             alt="Thumbnail Berita" 
                             class="w-full h-64 object-cover">
                    </div>
                </template>

                <!-- Judul Berita -->
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Judul Berita:</span>
                    <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white" x-text="modalData.name_berita"></p>
                </div>

                <!-- ID -->
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">ID Berita:</span>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400" x-text="modalData.id"></p>
                </div>

                <!-- Keterangan -->
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Keterangan:</span>
                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-300" x-text="modalData.keterangan"></p>
                </div>

                <!-- Tanggal Berita -->
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Tanggal Berita:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.tanggal"></p>
                </div>

                <!-- Penulis -->
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Penulis:</span>
                    <p class="mt-1 text-slate-700 dark:text-slate-300">
                        <span class="inline-flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600">
                                <span x-text="modalData.user_name ? modalData.user_name.charAt(0).toUpperCase() : '-'"></span>
                            </span>
                            <span x-text="modalData.user_name"></span>
                        </span>
                    </p>
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