<section id="acara" class="min-h-screen bg-gradient-to-b from-slate-50 to-white text-slate-900 dark:from-slate-950 dark:to-slate-900 dark:text-white" x-data="{
    detailOpen: false,
    daftarOpen: false,
    commentOpen: false,
    shareOpen: false,
    likeOpen: false,
    selected: null,
    daftarSelected: null
}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-12 text-center">
            <span class="inline-block rounded-full bg-indigo-100 px-5 py-2 text-sm font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                Acara & Kegiatan
            </span>
            <h1 class="mt-4 text-4xl font-extrabold text-slate-900 dark:text-white sm:text-5xl">
                Daftar Acara <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">HIMANIKKA</span>
            </h1>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
                Ikuti berbagai kegiatan dan event seru dari HIMANIKKA
            </p>
        </div>

        <!-- Statistik -->
        <div class="mb-12 grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="group rounded-2xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:bg-slate-800">
                <div class="flex items-center gap-4">
                    <div class="rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-3 text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path fill-rule="evenodd" d="M21 12c0 1.047-.89 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v2c0 1.103-.897 2-2 2h-2v-2h-2c-1.103 0-2-.897-2-2v-2H7c-1.11 0-2-.897-2-2v-2H3c-1.11 0-2-.897-2-2V2.375c0-.825.75-1.375 1.5-1.375h16.5c.75 0 1.5.55 1.5 1.375V12zm-5-2V5h-2v5h2zm-4 0V5h-2v5h2zm-4 0V5H7v5h2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Acara</p>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $acaras_count }}</p>
                    </div>
                </div>
            </div>
            
            <div class="group rounded-2xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:bg-slate-800">
                <div class="flex items-center gap-4">
                    <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Pendaftar</p>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $pendaftarans->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="group rounded-2xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:bg-slate-800">
                <div class="flex items-center gap-4">
                    <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-3 text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v.91c.79.125 1.51.427 2.08.912l.64-.64a.75.75 0 011.06 1.06l-.64.64c.485.57.787 1.29.912 2.08h.91a.75.75 0 010 1.5h-.91c-.125.79-.427 1.51-.912 2.08l.64.64a.75.75 0 11-1.06 1.06l-.64-.64c-.57.485-1.29.787-2.08.912v.91a.75.75 0 01-1.5 0v-.91c-.79-.125-1.51-.427-2.08-.912l-.64.64a.75.75 0 11-1.06-1.06l.64-.64c-.485-.57-.787-1.29-.912-2.08h-.91a.75.75 0 010-1.5h.91c.125-.79.427-1.51.912-2.08l-.64-.64a.75.75 0 011.06-1.06l.64.64c.57-.485 1.29-.787 2.08-.912v-.91A.75.75 0 0112 2.25zM12 15a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Acara Terbuka</p>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $acaras_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Acara -->
        @if(isset($acaras) && $acaras->count())
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($acaras as $acara)
                    <div class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-900">
                        <!-- Thumbnail -->
                        <div class="relative h-56 overflow-hidden bg-gradient-to-br from-indigo-500/10 to-purple-500/10">
                            @if($acara->thumnail)
                                <img
                                    src="{{ asset('storage/' . $acara->thumnail) }}"
                                    alt="{{ $acara->name_acara ?? 'Acara' }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-4xl font-bold text-white shadow-xl">
                                        {{ substr($acara->name_acara ?? 'A', 0, 1) }}
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Badge Tipe -->
                            @if($acara->tipe ?? null)
                                <div class="absolute top-4 left-4">
                                    <span class="rounded-lg bg-white/90 px-3 py-1 text-xs font-semibold text-slate-900 backdrop-blur-sm dark:bg-slate-900/90 dark:text-white">
                                        {{ $acara->tipe }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex flex-1 p-6">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                    {{ $acara->name_acara ?? 'Nama acara belum tersedia' }}
                                </h3>

                                <p class="mt-2 line-clamp-2 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $acara->keterangan ?? 'Deskripsi belum tersedia.' }}
                                </p>

                                <!-- Info -->
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        <span>{{ $acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span>{{ $acara->tempat ?? 'Tempat belum tersedia' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span>{{ $pendaftarans->where('acaras_id', $acara->id)->count() }} Peserta</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 px-6 pb-6">
                            <button
                                type="button"
                                class="flex-1 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition hover:from-indigo-700 hover:to-indigo-800 hover:shadow-xl"
                                @click="detailOpen = true; selected = {
                                    id: @js($acara->id),
                                    name_acara: @js($acara->name_acara ?? '-'),
                                    deskripsi: @js($acara->keterangan ?? '-'),
                                    tipe: @js($acara->tipe ?? '-'),
                                    tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-'),
                                    tempat: @js($acara->tempat ?? '-'),
                                    syarat: @js($acara->syarat->kebutuhan ?? '-'),
                                    thumnail: @js($acara->thumnail ? asset('storage/' . $acara->thumnail) : ''),
                                    user_id: @js($acara->user->name ?? '-'),
                                    biaya: @js($acara->biaya->nominal ?? '-'),
                                    status: 'Akan dihubungi oleh Panitia'
                                }"
                            >
                                Detail
                            </button>

                            <button
                                type="button"
                                class="flex-1 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition hover:from-emerald-700 hover:to-emerald-800 hover:shadow-xl"
                                @click="daftarOpen = true; daftarSelected = {
                                    id: @js($acara->id),
                                    name: @js($acara->name_acara ?? '-'),
                                    tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-')
                                }"
                            >
                                Daftar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-16 text-center dark:border-slate-700 dark:bg-slate-900">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-4xl font-bold text-white">
                    📅
                </div>
                <h2 class="mt-6 text-2xl font-bold text-slate-900 dark:text-white">Acara Belum Tersedia</h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400">
                    Data acara belum diinput ke dalam sistem.
                </p>
            </div>
        @endif

        <!-- Info Cards -->
        <div class="mt-16 grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-lg bg-indigo-100 p-2 dark:bg-indigo-900/40">
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Internal</h3>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Kegiatan yang diperuntukkan bagi lingkungan HIMANIKKA atau mahasiswa internal.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-lg bg-purple-100 p-2 dark:bg-purple-900/40">
                        <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">External</h3>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Event atau agenda yang melibatkan pihak luar organisasi.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-lg bg-emerald-100 p-2 dark:bg-emerald-900/40">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Syarat</h3>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Informasi tambahan untuk mengikuti kegiatan atau event tertentu.
                </p>
            </div>
        </div>
    </div>

    <!-- Modal Detail Acara -->
    <div x-cloak x-show="detailOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm" @click.away="detailOpen = false">
        <div class="relative w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="detailOpen = false">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-indigo-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="selected?.name_acara"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Detail Acara</p>
                </div>
                <button type="button" @click="detailOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Thumbnail -->
                <template x-if="selected?.thumnail">
                    <img :src="selected.thumnail" class="mb-5 h-64 w-full rounded-2xl object-cover" alt="Thumbnail acara">
                </template>

                <!-- Actions -->
                <div class="mb-5 flex flex-wrap items-center gap-3">
                    <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200" @click="likeOpen = true">
                        <svg class="h-5 w-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.217 25.18 25.18 0 01-4.207-3.06C4.99 15.09 3 12.11 3 8.75 3 5.307 5.784 2.5 9.25 2.5c1.74 0 3.31.82 4.25 2.1.94-1.28 2.51-2.1 4.25-2.1C21.216 2.5 24 5.307 24 8.75c0 3.36-1.99 6.34-4.026 8.868a25.18 25.18 0 01-4.207 3.06 15.247 15.247 0 01-.405.229l-.007.003-.002.001a1.75 1.75 0 01-1.677 0z"/>
                        </svg>
                        Like
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200" @click="commentOpen = true">
                        <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M4.804 3.757A2.75 2.75 0 017.14 2.5h9.72a2.75 2.75 0 012.75 2.75v8.5a2.75 2.75 0 01-2.75 2.75H10.5l-4.28 3.42A.75.75 0 014.5 19.25V16.5A2.75 2.75 0 012 13.75v-7.5c0-1.07.498-2.08 1.304-2.493z" clip-rule="evenodd"/>
                        </svg>
                        Masukkan
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200" @click="shareOpen = true">
                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Share
                    </button>
                </div>

                <!-- Info -->
                <div class="space-y-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    <p><span class="font-semibold text-slate-900 dark:text-white">Deskripsi:</span> <span x-text="selected?.deskripsi"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Tipe:</span> <span x-text="selected?.tipe"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Tanggal:</span> <span x-text="selected?.tanggal"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Tempat:</span> <span x-text="selected?.tempat"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Syarat:</span> <span x-text="selected?.syarat"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Penanggung Jawab:</span> <span x-text="selected?.user_id"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Biaya:</span> <span class="text-emerald-600 dark:text-emerald-400">Rp. </span><span x-text="selected?.biaya"></span></p>
                    <p><span class="font-semibold text-slate-900 dark:text-white">Status Pendaftaran:</span> <span class="text-emerald-600 dark:text-emerald-400">Pendaftaran Anda </span><span x-text="selected?.status"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Daftar -->
    <div x-cloak x-show="daftarOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm" @click.away="daftarOpen = false">
        <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="daftarOpen = false">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Daftar Acara</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400" x-text="daftarSelected?.name"></p>
                </div>
                <button type="button" @click="daftarOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Anda akan mendaftar untuk acara <span class="font-semibold" x-text="daftarSelected?.name"></span>.
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Tanggal: <span class="font-semibold" x-text="daftarSelected?.tanggal"></span>
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('pendaftaran.index') }}" class="flex-1 rounded-xl bg-emerald-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-emerald-700">
                        Lanjut Daftar
                    </a>
                    <button type="button" @click="daftarOpen = false" class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition dark:border-slate-700 dark:text-slate-200">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Like -->
    <div x-cloak x-show="likeOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm" @click.away="likeOpen = false">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="likeOpen = false">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Like</h3>
                <button type="button" @click="likeOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('acara.store') }}" class="mt-4 space-y-4">
                @csrf
                <input type="hidden" name="acaras_id" :value="selected?.id">
                <input type="hidden" name="like" value="1">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Klik tombol di bawah untuk memberi like pada acara ini.
                </p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
                    Kirim Like
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Masukkan -->
    <div x-cloak x-show="commentOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm" @click.away="commentOpen = false">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="commentOpen = false">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Masukkan</h3>
                <button type="button" @click="commentOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('acara.store') }}" class="mt-4 space-y-4">
                @csrf
                <input type="hidden" name="acaras_id" :value="selected?.id">
                <input type="hidden" name="Masukkan" value="Masukkan">
                <textarea
                    name="Masukkan"
                    rows="4"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    placeholder="Tulis masukkan kamu..."
                    required
                ></textarea>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Kirim Masukkan
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Share -->
    <div x-cloak x-show="shareOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm" @click.away="shareOpen = false">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="shareOpen = false">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Share</h3>
                <button type="button" @click="shareOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                Fitur share bisa dihubungkan ke link WhatsApp, copy link, atau sosial media.
            </p>
        </div>
    </div>
</section>