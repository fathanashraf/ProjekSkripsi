@extends('Mahasiswa.layouts.app')

@section('title', 'Beranda HIMANIKKA')

@section('content')
<main class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-950 dark:to-slate-900 text-slate-900 dark:text-white">
    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-40 -left-20 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 sm:py-20 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-6">
                        {{ $profils->name_instansi ?? 'HIMANIKKA' }}
                    </span>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                        Selamat Datang {{ auth()->user()->name }} di
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-teal-500">HIMANIKKA</span>
                    </h1>

                    <p class="mt-6 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
                        Website resmi Himpunan Mahasiswa Teknik Informatika Universitas Pahlawan Tuanku Tambusai untuk informasi organisasi, acara, berita, dan dokumentasi kegiatan.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('Mahasiswa.tentang.index') }}" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                            Tentang Kami
                        </a>
                        <a href="{{ route('Mahasiswa.berita.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            Lihat Berita
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-3 gap-4 max-w-xl">
                        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-800 p-4 shadow-sm">
                            <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $count['acara'] }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Acara</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-800 p-4 shadow-sm">
                            <p class="text-2xl font-black text-teal-600 dark:text-teal-400">{{ $count['berita'] }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Berita</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-800 p-4 shadow-sm">
                            <p class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $count['user'] }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Anggota</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 to-teal-500/20 blur-3xl rounded-full"></div>
                    <div class="relative rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xl bg-white dark:bg-slate-900">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="{{ asset('assets/logohima-.png') }}" alt="Logo HIMANIKKA" class="w-12 h-12 rounded-full object-cover">
                                <div>
                                    <h2 class="font-bold text-lg">
                                        {{ $profils->singkatan ?? 'HIMANIKKA' }}
                                    </h2>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{$profils->name_instansi}}</p>
                                </div>
                            </div>

                            <div class="relative">
                <div class="absolute -inset-6 -z-10 rounded-[2rem] bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 blur-3xl"></div>

                @php
                    $slides = collect()
                        ->merge(($acaras ?? collect())->map(function ($item) {
                            return [
                                'type' => 'Acara',
                                'title' => $item->name ?? $item->judul ?? 'Acara',
                                'image' => !empty($item->thumnail)
                                    ? Storage::url($item->thumnail)
                                    : asset('images/himanikka-illustration.svg'),
                                'desc' => \Illuminate\Support\Str::limit($item->deskripsi ?? '', 90),
                            ];
                        }))
                        ->merge(($beritas ?? collect())->map(function ($item) {
                            return [
                                'type' => 'Berita',
                                'title' => $item->judul ?? 'Berita',
                                'image' => !empty($item->thumbnail)
                                    ? Storage::url($item->thumbnail)
                                    : asset('images/himanikka-illustration.svg'),
                                'desc' => \Illuminate\Support\Str::limit($item->isi ?? '', 90),
                            ];
                        }))
                        ->take(6)
                        ->values();
                @endphp

<div
    x-data="{
        current: 0,
        slides: @js($slides),
        next() { this.current = (this.current + 1) % this.slides.length },
        prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length }
    }"
    x-init="if (slides.length > 1) setInterval(() => next(), 5000)"
    class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-white/70 p-4 shadow-2xl shadow-indigo-500/10 backdrop-blur dark:border-slate-800 dark:bg-slate-900/70"
    role="region"
    aria-roledescription="carousel"
    aria-label="Carousel Acara dan Berita"
>
    <div class="relative h-[420px] overflow-hidden rounded-[1.5rem] bg-slate-100 dark:bg-slate-800">
        <template x-for="(slide, index) in slides" :key="index">
            <div
                x-show="current === index"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0"
            >
                <img :src="slide.image" :alt="slide.title" class="h-full w-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold backdrop-blur" x-text="slide.type"></span>
                    <h3 class="mt-3 text-2xl font-bold" x-text="slide.title"></h3>
                    <p class="mt-2 max-w-2xl text-sm text-white/85" x-text="slide.desc"></p>
                </div>
            </div>
        </template>
    </div>

    <button
        type="button"
        @click="prev()"
        class="absolute left-6 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/90 p-3 text-slate-900 shadow-lg transition hover:bg-white dark:bg-slate-900/90 dark:text-white"
        aria-label="Previous slide"
    >
        ‹
    </button>

    <button
        type="button"
        @click="next()"
        class="absolute right-6 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/90 p-3 text-slate-900 shadow-lg transition hover:bg-white dark:bg-slate-900/90 dark:text-white"
        aria-label="Next slide"
    >
        ›
    </button>

    <div class="mt-4 flex items-center justify-between px-2">
        <div class="text-sm text-slate-500 dark:text-slate-400">
            <span x-text="current + 1"></span>/<span x-text="slides.length"></span>
        </div>

        <div class="flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button
                    type="button"
                    @click="current = index"
                    :class="current === index ? 'bg-indigo-600 w-8' : 'bg-slate-300 dark:bg-slate-600 w-2'"
                    class="h-2 rounded-full transition-all"
                    :aria-label="'Go to slide ' + (index + 1)"
                ></button>
            </template>
        </div>
    </div>
</div>

                <div class="absolute -left-4 bottom-6 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-xl dark:border-slate-700 dark:bg-slate-900">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">🚀 Sistem aktif</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Siap digunakan oleh pengurus dan mahasiswa</p>
                </div>
            </div>
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-4">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Acara </p>
                                    <p class="text-xl font-bold mt-1">Acara Organisasi</p>
                                </div>
                                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-4">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Update</p>
                                    <p class="text-xl font-bold mt-1">Berita Terkini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl sm:text-4xl font-black">Akses informasi dengan mudah</h2>
            <p class="mt-4 text-slate-600 dark:text-slate-300">
                Semua informasi penting HIMANIKKA tersedia dalam satu tempat yang rapi, cepat, dan responsif.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            <a href="{{ route('Mahasiswa.tentang.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xl">T</div>
                <h3 class="mt-4 font-bold text-lg group-hover:text-indigo-600 transition">Tentang Kami</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Pelajari sejarah dan identitas HIMANIKKA.</p>
            </a>

            <a href="{{ route('Mahasiswa.struktur.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 dark:bg-teal-500/15 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-xl">S</div>
                <h3 class="mt-4 font-bold text-lg group-hover:text-teal-600 transition">Struktur</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Lihat susunan pengurus organisasi.</p>
            </a>

            <a href="{{ route('Mahasiswa.acara.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xl">A</div>
                <h3 class="mt-4 font-bold text-lg group-hover:text-amber-600 transition">Acara</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Pantau agenda dan kegiatan terbaru.</p>
            </a>

            <a href="{{ route('Mahasiswa.berita.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold text-xl">B</div>
                <h3 class="mt-4 font-bold text-lg group-hover:text-rose-600 transition">Berita</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Baca update informasi dan publikasi.</p>
            </a>
        </div>
    </section>

    <!-- CTA -->
    <section class="max-w-6xl mx-auto px-4 pb-16">
        <div class="rounded-3xl bg-gradient-to-r from-indigo-600 to-teal-500 p-8 sm:p-10 text-white overflow-hidden relative">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-white blur-3xl"></div>
            </div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black">Siap terlibat dalam kegiatan HIMANIKKA?</h2>
                    <p class="mt-3 text-white/90 max-w-2xl">
                        Ikuti informasi terbaru, dokumentasi, dan agenda organisasi melalui halaman yang tersedia.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('Mahasiswa.acara.index') }}" class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-semibold hover:bg-slate-100 transition">
                        Lihat Acara
                    </a>
                    <a href="{{ route('Mahasiswa.berita.index') }}" class="px-6 py-3 rounded-xl border border-white/30 text-white font-semibold hover:bg-white/10 transition">
                        Baca Berita
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- form aspirasi -->
    <!-- form aspirasi -->
<section class="max-w-6xl mx-auto px-4 pb-16">
    <div class="mx-auto max-w-6xl px-4">
        <div class="mb-16 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border-2 border-indigo-300 bg-indigo-50 px-6 py-2.5 text-sm font-bold text-indigo-700 dark:text-indigo-300">Aspirasi Mahasiswa</span>
            <h2 class="mt-6 text-5xl font-extrabold text-slate-900 dark:text-white">Sampaikan <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Aspirasi Anda</span></h2>
            <p class="mx-auto mt-6 max-w-3xl text-xl text-slate-600 dark:text-slate-400">K Kritik, saran, dan masukan untuk pengurus HIMANIKKA.</p>
        </div>

        @if(session('success'))
        <div class="mb-8 flash-success">{{ session('success') }}</div>
        @endif

        <div class="rounded-[2.5rem] bg-white p-10 shadow-2xl dark:bg-slate-900 border border-slate-200">
            <form method="POST" action="{{ route('aspirasi.store') }}">
                @csrf
                <input type="hidden" name="Masukkan" value="aspirasi">
                <textarea name="Masukkan" rows="8" required class="w-full rounded-2xl border-2 border-slate-300 px-6 py-5 text-lg outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 dark:bg-slate-950 dark:border-slate-700" placeholder="Tuliskan aspirasi Anda..."></textarea>
                <button type="submit" class="mt-6 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-10 py-4 text-lg font-bold text-white hover:scale-105">Kirim Aspirasi</button>
            </form>
        </div>
    </div>
</section>
</main>
@endsection