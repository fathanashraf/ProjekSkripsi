@extends('Mahasiswa.layouts.app')

@section('title', 'Tentang HIMANIKKA')

@section('content')
@php
    $cards = [
        [
            'key' => 'fungsi',
            'title' => 'Fungsi',
            'default' => 'Belum Ada Data Fungsi HIMANIKKA.',
        ],
        [
            'key' => 'tujuan',
            'title' => 'Tujuan',
            'default' => 'Belum Ada Data Tujuan HIMANIKKA.',
        ],
        [
            'key' => 'tahun_berdiri',
            'title' => 'Tahun Berdiri',
            'default' => 'Belum Ada Data Tahun Berdiri HIMANIKKA.',
        ],
        
    ];
@endphp

<main
    class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-950 dark:to-slate-900 text-slate-900 dark:text-white"
    x-data="{
        open: false,
        openRingkasan: false,
        title: '',
        content: '',
        setModal(title, content) {
            this.title = title;
            this.content = content;
            this.open = true;
        }
    }"
>
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-40 -left-20 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 sm:py-20 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-6">
                        Profil Organisasi
                    </span>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                        Tentang
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-teal-500">
                            {{ $profil->singkatan ?? 'HIMANIKKA' }}
                        </span>
                    </h1>

                    <p class="mt-6 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
                        {{ $profil->name_instansi ?? 'Himpunan Mahasiswa Teknik Informatika Universitas Pahlawan Tuanku Tambusai' }}
                    </p>

                    @if (!empty($profil->alamat))
                        <div class="mt-6 flex items-start gap-3 text-slate-600 dark:text-slate-300">
                            <svg class="w-5 h-5 mt-0.5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.995 1.995 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p>{{ $profil->alamat }}</p>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        @if (!empty($profil->AD_ART))
                            <a href="{{ asset('storage/' . ltrim($profil->AD_ART, '/')) }}" target="_blank" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                                Lihat AD/ART
                            </a>
                        @endif

                        <a href="{{ route('Mahasiswa.acara.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            Lihat Acara
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 to-teal-500/20 blur-3xl rounded-full"></div>
                    <div class="relative rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xl bg-white dark:bg-slate-900 p-6 sm:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            @if (!empty($profil->logo))
                                <img src="{{ asset('storage/' . ltrim($profil->logo, '/')) }}" alt="Logo {{ $profil->singkatan ?? 'HIMANIKKA' }}" class="w-16 h-16 rounded-2xl object-cover">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-teal-500 flex items-center justify-center text-white font-black text-2xl">
                                    H
                                </div>
                            @endif

                            <div>
                                <h2 class="font-bold text-lg">{{ $profil->singkatan ?? 'HIMANIKKA' }}</h2>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $profil->name_instansi ?? 'Teknik Informatika UPTT' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($cards as $card)
                                @php
                                    $value = $profil->{$card['key']} ?? $card['default'];
                                @endphp

                                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-5 {{ $card['key'] === 'kedaulatan' ? 'md:col-span-2' : '' }}">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $card['title'] }}</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100 leading-relaxed line-clamp-2">
                                        {{ $value }}
                                    </p>

                                    <button
                                        type="button"
                                        class="mt-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline"
                                        @click="setModal(@js($card['title']), @js($value))"
                                    >
                                        Lihat selengkapnya
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid lg:grid-cols-2 gap-6">
            <button
                type="button"
                @click="setModal('Sejarah HIMANIKKA', @js($profil->sejarah ?? 'Data sejarah belum tersedia.'))"
                class="text-left rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
            >
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white">Sejarah</h2>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300 text-xl font-black">i</span>
                </div>

                <div class="mt-4 text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-4 whitespace-pre-line">
                    {{ $profil->sejarah ?? 'Data sejarah belum tersedia.' }}
                </div>

                <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                    Lihat selengkapnya...
                </div>
            </button>

            <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white">Visi & Misi</h2>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-teal-100 text-teal-600 dark:bg-teal-500/15 dark:text-teal-300 text-xl font-black">i</span>
                </div>

                <div class="mt-6 space-y-8">
                    <button type="button" @click="setModal('Visi HIMANIKKA', @js($profil->visi ?? 'Data visi belum tersedia.'))" class="w-full text-left">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Visi</h3>
                        <p class="mt-3 text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3 whitespace-pre-line">
                            {{ $profil->visi ?? 'Data visi belum tersedia.' }}
                        </p>
                        <div class="mt-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                            Lihat selengkapnya...
                        </div>
                    </button>

                    <button type="button" @click="setModal('Misi HIMANIKKA', @js($profil->misi ?? 'Data misi belum tersedia.'))" class="w-full text-left border-t border-slate-200 dark:border-slate-800 pt-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Misi</h3>
                        <div class="mt-3 text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-4 whitespace-pre-line">
                            {{ $profil->misi ?? 'Data misi belum tersedia.' }}
                        </div>
                        <div class="mt-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                            Lihat selengkapnya...
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[999] flex items-center justify-center p-4"
            @keydown.escape.window="open = false"
        >
            <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" @click="open = false"></div>

            <div
                x-show="open"
                x-transition.scale.origin.center
                class="relative w-full max-w-3xl overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xl"
            >
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Profil HIMANIKKA</p>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white" x-text="title"></h2>
                    </div>

                    <button type="button" @click="open = false" class="w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-5">
                        <div class="whitespace-pre-line text-sm sm:text-base leading-7 text-slate-700 dark:text-slate-300" x-text="content"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 pb-16">
        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xl">1</div>
                <h3 class="mt-4 font-bold text-lg">Kolaborasi</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Membangun kerja sama antaranggota untuk tujuan bersama.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 dark:bg-teal-500/15 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-xl">2</div>
                <h3 class="mt-4 font-bold text-lg">Inovasi</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Mendorong ide baru yang relevan dengan perkembangan teknologi.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xl">3</div>
                <h3 class="mt-4 font-bold text-lg">Kontribusi</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Menghadirkan kegiatan yang bermanfaat untuk mahasiswa dan kampus.</p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 pb-16">
        <div class="rounded-3xl bg-gradient-to-r from-indigo-600 to-teal-500 p-8 sm:p-10 text-white overflow-hidden relative">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-white blur-3xl"></div>
            </div>

            <button type="button" @click="openRingkasan = true" class="w-full text-left">
                <div class="relative rounded-2xl bg-white/10 border border-white/20 p-5 backdrop-blur-sm">
                    <h2 class="text-2xl sm:text-3xl font-black text-white">File dan dokumen</h2>

                    <div class="mt-8 grid md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-white/10 border border-white/20 p-5 backdrop-blur-sm">
                            <p class="text-sm text-white/70">AD/ART</p>
                            <h3 class="mt-1 font-bold text-lg text-white">
                                {{ !empty($profil->AD_ART) ? 'Tersedia' : 'Belum tersedia' }}
                            </h3>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/20 p-5 backdrop-blur-sm">
                            <p class="text-sm text-white/70">Mars Mahasiswa</p>
                            <h3 class="mt-1 font-bold text-lg text-white">
                                {{ !empty($profil->mars_mahasiswa) ? 'Tersedia' : 'Belum tersedia' }}
                            </h3>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/20 p-5 backdrop-blur-sm">
                            <p class="text-sm text-white/70">Hymne Teknik</p>
                            <h3 class="mt-1 font-bold text-lg text-white">
                                {{ !empty($profil->hymne_teknik) ? 'Tersedia' : 'Belum tersedia' }}
                            </h3>
                        </div>
                    </div>

                    <div class="mt-5 text-sm font-semibold text-indigo-200">
                        Klik untuk lihat detail
                    </div>
                </div>
            </button>

            <div
                x-cloak
                x-show="openRingkasan"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
                @keydown.escape.window="openRingkasan = false"
            >
                <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="openRingkasan = false">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">File dan dokumen</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Status ketersediaan dokumen organisasi</p>
                        </div>
                        <button type="button" @click="openRingkasan = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <div class="p-6">
                        <div class="grid gap-4 md:grid-cols-3">
                            <a href="{{ !empty($profil->AD_ART) ? Storage::url($profil->AD_ART) : '#' }}" target="_blank" class="rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700">
                                <p class="text-sm text-slate-500 dark:text-slate-400">AD/ART</p>
                                <h3 class="mt-1 font-bold text-lg text-slate-900 dark:text-white">
                                    {{ !empty($profil->AD_ART) ? 'Tersedia' : 'Belum tersedia' }}
                                </h3>
                            </a>

                            <a href="{{ !empty($profil->mars_mahasiswa) ? Storage::url($profil->mars_mahasiswa) : '#' }}" target="_blank" class="rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700">
                                <p class="text-sm text-slate-500 dark:text-slate-400">Mars Mahasiswa</p>
                                <h3 class="mt-1 font-bold text-lg text-slate-900 dark:text-white">
                                    {{ !empty($profil->mars_mahasiswa) ? 'Tersedia' : 'Belum tersedia' }}
                                </h3>
                            </a>

                            <a href="{{ !empty($profil->hymne_teknik) ? Storage::url($profil->hymne_teknik) : '#' }}" target="_blank" class="rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700">
                                <p class="text-sm text-slate-500 dark:text-slate-400">Hymne Teknik</p>
                                <h3 class="mt-1 font-bold text-lg text-slate-900 dark:text-white">
                                    {{ !empty($profil->hymne_teknik) ? 'Tersedia' : 'Belum tersedia' }}
                                </h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection