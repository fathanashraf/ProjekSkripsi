@extends('Mahasiswa.layouts.app')

@section('title', 'Acara HIMANIKKA')

@section('content')
<main class="min-h-screen bg-gradient-to-b from-slate-50 to-white text-slate-900 dark:from-slate-950 dark:to-slate-900 dark:text-white">

    <section class="bg-slate-50 py-16 dark:bg-slate-900">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-4xl font-black leading-tight text-slate-900 dark:text-white">
                Daftar Acara HIMANIKKA
            </h1>
            
            <!-- status Pendaftaran -->
            
        </div>
        
        <!-- Statistik cepat -->
        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl bg-white p-5 shadow-sm dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-indigo-100 p-2.5 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-indigo-600 dark:text-indigo-400">
                            <path fill-rule="evenodd" d="M21 12c0 1.047-.89 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v-2h-2c-1.103 0-2-.897-2-2v-2H7c-1.11 0-2-.897-2-2v-2H3c-1.11 0-2-.897-2-2V2.375c0-.825.75-1.375 1.5-1.375h16.5c.75 0 1.5.55 1.5 1.375V12zm-5-2V5h-2v5h2zm-4 0V5h-2v5h2zm-4 0V5H7v5h2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Acara</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ ($acaras_count) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-xl bg-white p-5 shadow-sm dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-emerald-100 p-2.5 dark:bg-emerald-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-600 dark:text-emerald-400">
                            <path d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Pendaftar</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $pendaftarans->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-xl bg-white p-5 shadow-sm dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-amber-100 p-2.5 dark:bg-amber-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-amber-600 dark:text-amber-400">
                            <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v.91c.79.125 1.51.427 2.08.912l.64-.64a.75.75 0 011.06 1.06l-.64.64c.485.57.787 1.29.912 2.08h.91a.75.75 0 010 1.5h-.91c-.125.79-.427 1.51-.912 2.08l.64.64a.75.75 0 11-1.06 1.06l-.64-.64c-.57.485-1.29.787-2.08.912v.91a.75.75 0 01-1.5 0v-.91c-.79-.125-1.51-.427-2.08-.912l-.64.64a.75.75 0 11-1.06-1.06l.64-.64c-.485-.57-.787-1.29-.912-2.08h-.91a.75.75 0 010-1.5h.91c.125-.79.427-1.51.912-2.08l-.64-.64a.75.75 0 011.06-1.06l.64.64c.57-.485 1.29-.787 2.08-.912v-.91A.75.75 0 0112 2.25zM12 15a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Acara Terbuka</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ ($acaras_count) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Detail Status Pendaftaran -->
<div 
    x-show="detailOpen" 
    @click.away="detailOpen = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex min-h-screen items-center justify-center px-4 py-6 pt-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-70 transition-opacity" @click="detailOpen = false"></div>
        
        <div class="inline-flex transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                <h3 class="text-xl font-bold text-white">Detail Status Pendaftaran</h3>
                <p class="mt-1 text-sm text-indigo-100">@{{ selected.name }}</p>
            </div>
            
            <div class="px-6 py-6">
                <!-- Info acara -->
                <div class="mb-6 rounded-xl bg-slate-50 p-5 dark:bg-slate-700">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">@{{ selected.tanggal }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Tempat</p>
                            <p class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">@{{ selected.tempat }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Jumlah Pendaftar</p>
                            <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">@{{ selected.pendaftarCount }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Status</p>
                            <span class="mt-1 inline-block rounded-lg bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                @{{ selected.status }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Daftar pendaftar -->
                <div>
                    <h4 class="mb-3 text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Pendaftar</h4>
                    
                    <div class="max-h-60 overflow-y-auto rounded-xl border border-slate-200 dark:border-slate-700">
                        @if($pendaftarans->count() > 0)
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300">No</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300">Nama</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300">Email</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300">Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendaftarans as $pendaftaran)
                                        <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-700">
                                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400"></td>
                                            <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $pendaftaran->name }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400"></td>
                                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="flex items-center justify-center py-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12 text-slate-300 dark:text-slate-600">
                                    <path d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z"/>
                                </svg>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Belum ada pendaftar</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Acara ini masih terbuka untuk pendaftaran</p>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
            
            <div class="bg-slate-50 px-6 py-4 dark:bg-slate-700">
                <button 
                    type="button"
                    class="w-full rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-slate-600 dark:text-slate-200 dark:hover:bg-slate-500"
                    @click="detailOpen = false"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

    <section class="mx-auto max-w-6xl px-4 pb-16">
        <div
            x-data="{
                detailOpen: false,
                daftarOpen: false,
                commentOpen: false,
                shareOpen: false,
                likeOpen: false,
                dislikeOpen: false,
                selected: null,
                daftarSelected: null
            }"
            @keydown.escape.window="detailOpen = false; daftarOpen = false; commentOpen = false; shareOpen = false; likeOpen = false"
        >
            @if(isset($acaras) && $acaras->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($acaras as $acara)
                        <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-900">
                            <div
                                class="cursor-pointer"
                                @click="detailOpen = true; selected = {
                                    id: @js($acara->id),
                                    name: @js($acara->name_acara ?? '-'),
                                    deskripsi: @js($acara->keterangan ?? '-'),
                                    tipe: @js($acara->tipe ?? '-'),
                                    tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-'),
                                    tempat: @js($acara->tempat ? ($acara->tempat) : '-'),
                                    syarat: @js($acara->syarat->kebutuhan ?? '-'),
                                    thumnail: @js($acara->thumnail ? asset('storage/' . $acara->thumnail) : ''),
                                    user_id: @js($acara->user->name ?? '-'),
                                    biaya: @js($acara->biaya ? 'Rp ' . number_format($acara->biaya->nominal, 0, ',', '.') : '-'),
                                    status: @js ($pendaftaran->status ?? '-')
                                }"
                            >
                                <div class="relative flex h-72 items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-500/10 to-teal-500/10">
                                    @if($acara->thumnail)
                                        <img
                                            src="{{ asset('storage/' . $acara->thumnail) }}"
                                            alt="{{ $acara->name_acara ?? 'Acara' }}"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-teal-500 text-4xl font-black text-white shadow-xl">
                                                A
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                        {{ $acara->name_acara ?? 'Nama acara belum tersedia' }}
                                    </h3>

                                    <p class="mt-2 line-clamp-2 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $acara->keterangan ?? 'Deskripsi belum tersedia.' }}
                                    </p>

                                    <span class="mt-4 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        {{ $acara->tempat ?? 'Tempat belum tersedia' }}
                                    </span>

                                    <span class="mt-4 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        {{ $acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-' }}
                                    </span>

                                    <!-- jumlah pendaftar -->
                                    <span class="mt-4 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        {{ $pendaftarans->count() }} Peserta
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-3 px-6 pb-6">
                                <button
                                    type="button"
                                    class="inline-flex flex-1 items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                                    @click="detailOpen = true; selected = {
                                        id: @js($acara->id),
                                        name_acara: @js($acara->name_acara ?? '-'),
                                        deskripsi: @js($acara->keterangan ?? '-'),
                                        tipe: @js($acara->tipe ?? '-'),
                                        tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-'),
                                        tempat: @js($acara->tempat ? ($acara->tempat) : '-'),
                                        syarat: @js($acara->syarat->kebutuhan ?? '-'),
                                        thumnail: @js($acara->thumnail ? asset('storage/' . $acara->thumnail) : ''),
                                        user_id: @js($acara->user->name ?? '-'),
                                        biaya: @js($acara->biaya ? 'Rp ' . number_format($acara->biaya->nominal, 0, ',', '.') : '-'),
                                        status: @js($pendaftaran->status ?? 'Anda Belum Mendaftar')
                                    }"
                                >
                                    Detail
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                                    @click="daftarOpen = true; daftarSelected = {
                                        id: @js($acara->id),
                                        name: @js($acara->name_acara ?? '-'),
                                        tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-')
                                    }"
                                >
                                    Daftar Acara
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white/70 p-12 text-center dark:border-slate-700 dark:bg-slate-900/70">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-black text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        !
                    </div>
                    <h2 class="mt-4 text-2xl font-bold">Acara belum tersedia</h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Data acara belum diinput ke dalam sistem.
                    </p>
                </div>
            @endif

            <div x-cloak x-show="detailOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="detailOpen = false">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="selected?.name_acara"></h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Detail Acara</p>
                        </div>
                        <button type="button" @click="detailOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <div class="p-6">
                        <template x-if="selected?.thumnail">
                            <img :src="selected.thumnail" class="mb-5 h-64 w-full rounded-2xl object-cover" alt="thumnail acara">
                        </template>

                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="likeOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.217 25.18 25.18 0 01-4.207-3.06C4.99 15.09 3 12.11 3 8.75 3 5.307 5.784 2.5 9.25 2.5c1.74 0 3.31.82 4.25 2.1.94-1.28 2.51-2.1 4.25-2.1C21.216 2.5 24 5.307 24 8.75c0 3.36-1.99 6.34-4.026 8.868a25.18 25.18 0 01-4.207 3.06 15.247 15.247 0 01-.405.229l-.007.003-.002.001a1.75 1.75 0 01-1.677 0z"/>
    </svg>
    Like
</button>

<button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="commentOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path fill-rule="evenodd" d="M4.804 3.757A2.75 2.75 0 017.14 2.5h9.72a2.75 2.75 0 012.75 2.75v8.5a2.75 2.75 0 01-2.75 2.75H10.5l-4.28 3.42A.75.75 0 014.5 19.25V16.5A2.75 2.75 0 012 13.75v-7.5c0-1.07.498-2.08 1.304-2.493z" clip-rule="evenodd"/>
    </svg>
    Komentar
</button>

 <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="dislikeOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
  <path d="M7 11V3a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2-2l-1-5a2 2 0 0 0-2-2h-7a3 3 0 0 0-3 3v6z"/>
</svg>
    dislike
</button>

<button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="shareOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path d="M15.75 5.25a3.75 3.75 0 11-2.94 6.08l-4.93 2.46a3.756 3.756 0 010 1.42l4.93 2.46a3.75 3.75 0 11-.67 1.34l-4.93-2.46a3.75 3.75 0 110-5.44l4.93-2.46A3.75 3.75 0 0115.75 5.25z"/>
    </svg>
    Share
</button>

<!-- Modal Share (tambahkan di bawah file) -->

                        </div>

                        <div class="space-y-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            <p><span class="font-semibold text-slate-900 dark:text-white">Deskripsi:</span> <span x-text="selected?.deskripsi"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Tipe:</span> <span x-text="selected?.tipe"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Tanggal:</span> <span x-text="selected?.tanggal"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">tempat:</span> <span x-text="selected?.tempat"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Syarat:</span> <span x-text="selected?.syarat"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Penanggung Jawab:</span> <span x-text="selected?.user_id"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Biaya Pendaftaran:</span> <span x-text="selected?.biaya"></span></p>
                            <p><span class="font-semibold text-slate-900 dark:text-white">Status Pendaftaran:</span> <span>Status Pendaftaran Anda</span> <span x-text="selected?.status" class="inline-flex items-center px-3 py-1 text-sm font-medium border border-blue-500 text-blue-600 rounded-full"></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="daftarOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="daftarOpen = false">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Daftar Acara</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400" x-text="daftarSelected?.name"></p>
                        </div>
                        <button type="button" @click="daftarOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <div class="space-y-4 p-6">
                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Anda akan mendaftar untuk acara <span class="font-semibold" x-text="daftarSelected?.name"></span>.
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Tanggal acara: <span class="font-semibold" x-text="daftarSelected?.tanggal"></span>
                        </p>

                        <div class="flex gap-3">
                            <a href="{{ route('Mahasiswa.pendaftaran.index') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                Lanjut Daftar
                            </a>
                            <button type="button" @click="daftarOpen = false" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-200">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="likeOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="likeOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Like</h3>
                        <button type="button" @click="likeOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.acara.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="acaras_id" :value="selected?.id">
                        <input type="hidden" name="like" value="1">
                        <input type="hidden" name="dislike" value="">
                        <input type="hidden" name="Masukkan" value="">

                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Klik tombol di bawah untuk memberi like pada acara ini.
                        </p>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
                            Kirim Like
                        </button>
                    </form>
                </div>
            </div>

            <div x-cloak x-show="commentOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="commentOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Komentar</h3>
                        <button type="button" @click="commentOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.acara.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="acaras_id" :value="selected?.id">
                        <input type="hidden" name="Masukkan" value="Masukkan">
                        <input type="hidden" name="like" value="">
                        <input type="hidden" name="dislike" value="">

                        <textarea
                            name="Masukkan"
                            rows="4"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                            placeholder="Tulis komentar kamu..."
                            required
                        ></textarea>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>

            <div x-cloak x-show="dislikeOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="dislikeOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Like</h3>
                        <button type="button" @click="dislikeOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.acara.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="acaras_id" :value="selected?.id">
                        <input type="hidden" name="like" value="">
                        <input type="hidden" name="dislike" value="1">
                        <input type="hidden" name="Masukkan" value="">

                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Klik tombol di bawah untuk memberi dislike pada acara ini.
                        </p>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
                            Tidak Sukai
                        </button>
                    </form>
                </div>
            </div>

            <div x-cloak x-show="shareOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="shareOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Share</h3>
                        <button type="button" @click="shareOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Fitur share bisa dihubungkan ke link WhatsApp, copy link, atau sosial media.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16">
        <div class="grid gap-5 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">Internal</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Kegiatan yang diperuntukkan bagi lingkungan HIMANIKKA atau mahasiswa internal.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">External</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Event atau agenda yang melibatkan pihak luar organisasi.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">Syarat</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Informasi tambahan untuk mengikuti kegiatan atau event tertentu.
                </p>
            </div>
        </div>
    </section>
</main>
@endsection