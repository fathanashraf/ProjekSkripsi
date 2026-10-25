@php
    $profil = $profil ?? new \App\Models\Profil();
@endphp

<div class="relative" x-data="{
    open: false,
    title: '',
    content: '',
    mediaType: '',
    mediaUrl: '',
    openModal(title, content, type = '', url = '') {
        this.title = title;
        this.content = content;
        this.mediaType = type;
        this.mediaUrl = url;
        this.open = true;
    },
    closeModal() {
        this.open = false;
        this.mediaType = '';
        this.mediaUrl = '';
    }
}">
    {{-- Animated Grid Background --}}
    <div class="absolute inset-0 opacity-[0.04] dark:opacity-[0.03] pointer-events-none">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(99,102,241,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.5) 1px, transparent 1px); background-size: 80px 80px;"></div>
    </div>

    {{-- Floating Orbs --}}
    <div class="absolute -top-32 right-0 h-64 w-64 animate-pulse rounded-full bg-indigo-500/10 blur-[120px] dark:bg-indigo-500/5" style="animation-duration: 6s;"></div>
    <div class="absolute -bottom-20 -left-20 h-56 w-56 animate-pulse rounded-full bg-purple-500/10 blur-[120px] dark:bg-purple-500/5" style="animation-duration: 8s;"></div>

    <div class="relative mx-auto max-w-7xl px-4">
        {{-- Section Header --}}
        <div class="mb-16 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-indigo-500/30 bg-white/5 px-5 py-2 text-sm font-semibold text-indigo-300 shadow-lg backdrop-blur-xl transition-all hover:border-indigo-400/50 hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                TENTANG ORGANISASI
            </span>
            <h2 class="mt-6 text-4xl font-extrabold text-slate-900 dark:text-white sm:text-5xl">
                Tentang <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">{{ $profil->singkatan ?? 'HIMANIKKA' }}</span>
            </h2>
            <p class="mx-auto mt-6 max-w-3xl text-lg text-slate-600 dark:text-slate-400">{{ $profil->name_instansi ?? 'Himpunan Mahasiswa Teknik Informatika' }}</p>
        </div>

        {{-- Hero Profile Card --}}
        <div class="group relative mb-12 overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white/90 shadow-xl backdrop-blur-xl transition-all hover:shadow-2xl dark:border-slate-700/40 dark:bg-slate-900/90">
            <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            <div class="relative flex flex-col items-center gap-8 p-8 md:flex-row md:p-10">
                @if($profil->logo ?? null)
                    <div class="group relative flex-shrink-0">
                        <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 blur-xl opacity-0 transition-opacity group-hover:opacity-100"></div>
                        <img src="{{ asset('storage/' . $profil->logo) }}" class="relative h-32 w-32 rounded-2xl object-cover shadow-xl ring-2 ring-indigo-200/50 dark:ring-indigo-700/50" alt="Logo">
                    </div>
                @endif
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $profil->singkatan ?? 'HIMANIKKA' }}</h3>
                    <p class="mt-2 flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 md:justify-start">
                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $profil->alamat ?? '-' }}
                    </p>
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-3 md:justify-start">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-indigo-500/10 to-purple-500/10 px-4 py-1.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300 ring-1 ring-indigo-200/50 dark:ring-indigo-700/50">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Berdiri: {{ $profil->tahun_berdiri ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sejarah --}}
        <div class="mb-12">
            <button type="button" @click="openModal('Sejarah', @js($profil->sejarah ?? 'Data sejarah belum tersedia.'))"
                class="group relative w-full overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white/90 p-8 shadow-lg backdrop-blur-xl transition-all hover:-translate-y-1 hover:shadow-2xl dark:border-slate-700/40 dark:bg-slate-900/90">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-indigo-500/5 blur-3xl transition-all duration-500 group-hover:bg-indigo-500/10"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="text-left">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Sejarah</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Perjalanan organisasi dari masa ke masa</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                        <span class="opacity-0 transition-all duration-300 group-hover:opacity-100">Selengkapnya</span>
                        <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <p class="mt-6 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-3">{{ $profil->sejarah ?? 'Data sejarah belum tersedia.' }}</p>
            </button>
        </div>

        {{-- Cards Grid --}}
        <div class="mb-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($cards as $index => $card)
                <button type="button"
                    @click="openModal('{{ $card['title'] }}', @js($profil->{$card['key']} ?? 'Data belum tersedia.'))"
                    class="group relative overflow-hidden rounded-[1.5rem] border border-slate-200/60 bg-white/90 p-7 shadow-lg backdrop-blur-xl transition-all hover:-translate-y-2 hover:shadow-2xl dark:border-slate-700/40 dark:bg-slate-900/90">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-purple-50/30 opacity-0 transition-opacity duration-300 group-hover:opacity-100 dark:from-indigo-950/30 dark:to-purple-950/20"></div>
                    <div class="relative inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white mb-5 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-indigo-500/25">
                        <span class="text-xl font-bold">{{ $index + 1 }}</span>
                    </div>
                    <h3 class="relative font-bold text-xl mb-3 text-slate-900 dark:text-white">{{ $card['title'] }}</h3>
                    <p class="relative text-sm leading-relaxed text-slate-600 dark:text-slate-400 line-clamp-3">{{ $profil->{$card['key']} ?? '-' }}</p>
                    <div class="relative mt-4 flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 transition-all duration-300 group-hover:gap-2">Selengkapnya<svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
                </button>
            @endforeach
        </div>

        {{-- Visi, Misi, Media Grid --}}
        <div class="grid gap-8 md:grid-cols-2">
            {{-- Visi --}}
            <button type="button" @click="openModal('Visi', @js($profil->visi ?? 'Data visi belum tersedia.'))"
                class="group relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-indigo-600 to-indigo-700 p-8 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl hover:shadow-indigo-500/30 text-left">
                <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 backdrop-blur">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Visi</h3>
                    </div>
                    <p class="text-white/90 leading-relaxed whitespace-pre-line line-clamp-4">{{ $profil->visi ?? '-' }}</p>
                    <div class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-indigo-200 transition-all duration-300 group-hover:gap-2">Selengkapnya<svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
                </div>
            </button>

            {{-- Misi --}}
            <button type="button" @click="openModal('Misi', @js($profil->misi ?? 'Data misi belum tersedia.'))"
                class="group relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-purple-600 to-pink-600 p-8 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl hover:shadow-purple-500/30 text-left">
                <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-purple-400/20 blur-3xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 backdrop-blur">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Misi</h3>
                    </div>
                    <p class="text-white/90 leading-relaxed whitespace-pre-line line-clamp-4">{{ $profil->misi ?? '-' }}</p>
                    <div class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-purple-200 transition-all duration-300 group-hover:gap-2">Selengkapnya<svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
                </div>
            </button>

            {{-- Hymne Teknik --}}
            <button type="button" @click="openModal('Hymne Teknik', @js($profil->hymne_teknik_desc ?? 'Lirik Hymne Teknik'), 'video', @js($profil->hymne_teknik ? Storage::url($profil->hymne_teknik) : ''))"
                class="group relative overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white/90 p-8 shadow-lg backdrop-blur-xl transition-all hover:-translate-y-1 hover:shadow-2xl dark:border-slate-700/40 dark:bg-slate-900/90 text-left">
                <div class="absolute -left-10 -top-10 h-36 w-36 rounded-full bg-indigo-500/5 blur-3xl transition-all group-hover:bg-indigo-500/10"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Hymne Teknik</h3>
                    </div>
                    @if($profil->hymne_teknik ?? null)
                        <div class="mt-4 flex items-center gap-4 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 p-4 dark:from-indigo-950/40 dark:to-purple-950/30">
                            <svg class="h-12 w-12 flex-shrink-0 text-indigo-500 dark:text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Audio tersedia</p>
                                <p class="text-xs text-indigo-500/80 dark:text-indigo-400/80">Klik untuk mendengarkan & melihat lirik</p>
                            </div>
                        </div>
                    @else
                        <p class="text-slate-600 dark:text-slate-400">File hymne teknik belum tersedia.</p>
                    @endif
                    <div class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 transition-all duration-300 group-hover:gap-2">Play Hymne<svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
                </div>
            </button>

            {{-- Mars Mahasiswa --}}
            <button type="button" @click="openModal('Mars Mahasiswa', @js($profil->mars_mahasiswa_desc ?? 'Lirik Mars Mahasiswa'), 'video', @js($profil->mars_mahasiswa ? Storage::url($profil->mars_mahasiswa) : ''))"
                class="group relative overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white/90 p-8 shadow-lg backdrop-blur-xl transition-all hover:-translate-y-1 hover:shadow-2xl dark:border-slate-700/40 dark:bg-slate-900/90 text-left">
                <div class="absolute -left-10 -top-10 h-36 w-36 rounded-full bg-purple-500/5 blur-3xl transition-all group-hover:bg-purple-500/10"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Mars Mahasiswa</h3>
                    </div>
                    @if($profil->mars_mahasiswa ?? null)
                        <div class="mt-4 flex items-center gap-4 rounded-xl bg-gradient-to-r from-purple-50 to-pink-50 p-4 dark:from-purple-950/40 dark:to-pink-950/30">
                            <svg class="h-12 w-12 flex-shrink-0 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-purple-700 dark:text-purple-300">Audio tersedia</p>
                                <p class="text-xs text-purple-500/80 dark:text-purple-400/80">Klik untuk mendengarkan & melihat lirik</p>
                            </div>
                        </div>
                    @else
                        <p class="text-slate-600 dark:text-slate-400">File mars mahasiswa belum tersedia.</p>
                    @endif
                    <div class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-purple-600 dark:text-purple-400 transition-all duration-300 group-hover:gap-2">Play Mars<svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
                </div>
            </button>
        </div>

        {{-- Modal --}}
        <div x-show="open" x-cloak x-transition.opacity.duration.300 class="fixed inset-0 z-[9999] flex items-center justify-center overflow-y-auto p-4 sm:p-6" @keydown.escape.window="closeModal()" role="dialog" aria-modal="true">
            <div x-show="open" x-transition.opacity.duration.300 class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="closeModal()"></div>
            <div x-show="open" x-transition.scale.origin.center.duration.300 class="relative z-[1000] my-8 w-full max-w-2xl overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white shadow-2xl dark:border-slate-700/40 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200/60 px-6 py-5 dark:border-slate-700/40 bg-gradient-to-r from-indigo-50/80 to-white dark:from-slate-800 dark:to-slate-900">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Profil HIMANIKKA</p>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white" x-text="title"></h2>
                    </div>
                    <button type="button" @click="closeModal()" class="flex h-11 w-11 items-center justify-center rounded-xl transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="h-6 w-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-6 max-h-[70vh]">
                    <template x-if="mediaType === 'video'">
                        <div class="rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-6 dark:from-slate-800 dark:to-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <div class="space-y-4">
                                <video id="video-player" controls class="w-full rounded-xl accent-indigo-600" :src="mediaUrl" x-init="$nextTick(() => { const video = document.getElementById('video-player'); if(video && mediaUrl) { console.log('Loading video:', mediaUrl); } })"><p class="text-slate-600">Browser Anda tidak mendukung video player.</p></video>
                                <div x-show="!mediaUrl" class="rounded-lg bg-red-50 p-4 dark:bg-red-900/20 border border-red-200 dark:border-red-800"><p class="text-sm text-red-700 dark:text-red-400">File video tidak tersedia.</p></div>
                            </div>
                            <div class="mt-6 rounded-lg bg-white p-4 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <h4 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2"><svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Lirik & Makna</h4>
                                <div class="text-base leading-7 text-slate-700 dark:text-slate-300" x-html="content"></div>
                            </div>
                        </div>
                    </template>
                    <template x-if="mediaType !== 'video'">
                        <div class="rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-6 dark:from-slate-800 dark:to-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <div class="text-base leading-8 text-slate-700 dark:text-slate-300 whitespace-pre-line" x-html="content"></div>
                        </div>
                    </template>
                </div>
                <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                    <button type="button" @click="closeModal()" class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
