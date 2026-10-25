{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome To HIMANIKKA')

@php
    use Illuminate\Support\Str;

    $slides = collect()
        ->merge(($acaras ?? collect())->map(function ($item) {
            return [
                'type' => 'Acara',
                'title' => $item->name_acara ?? $item->name_acara ?? 'Acara',
                'image' => !empty($item->thumnail)
                    ? Storage::url($item->thumnail)
                    : asset('images/himanikka-illustration.svg'),
                'desc' => Str::limit($item->keterangan ?? '', 90),
            ];
        }))
        ->merge(($beritas ?? collect())->map(function ($item) {
            return [
                'type' => 'Berita',
                'title' => $item->name_berita ?? 'Berita',
                'image' => !empty($item->thumnail)
                    ? Storage::url($item->thumnail)
                    : asset('images/himanikka-illustration.svg'),
                'desc' => Str::limit($item->isi ?? $item->keterangan ?? '', 90),
            ];
        }))
        ->take(6)
        ->values();
    
    $profil = $profil ?? new \App\Models\Profil();

    $cards = [
        ['key' => 'fungsi', 'title' => 'Fungsi'],
        ['key' => 'tujuan', 'title' => 'Tujuan'],
        ['key' => 'tahun_berdiri', 'title' => 'Tahun Berdiri'],
    ];
@endphp

@section('content')
{{-- ============================================================ --}}
{{-- HERO SECTION --}}
{{-- ============================================================ --}}
<section id="hero_section" class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-slate-100 dark:from-slate-900 dark:via-indigo-950 dark:to-slate-900">
    {{-- Animated Grid Background --}}
    <div class="absolute inset-0 opacity-[0.05] dark:opacity-[0.08]">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(99,102,241,0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.15) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    {{-- Floating Orbs --}}
    <div class="absolute top-1/4 right-1/4 h-72 w-72 animate-pulse rounded-full bg-indigo-500/20 blur-[100px] dark:bg-indigo-500/10" style="animation-duration: 4s;"></div>
    <div class="absolute bottom-1/4 left-1/4 h-80 w-80 animate-pulse rounded-full bg-purple-500/20 blur-[100px] dark:bg-purple-500/10" style="animation-duration: 6s;"></div>
    <div class="absolute top-1/3 left-2/3 h-64 w-64 animate-pulse rounded-full bg-cyan-500/15 blur-[100px] dark:bg-cyan-500/8" style="animation-duration: 5s;"></div>

    {{-- Hero Content --}}
    <div class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Left: Text --}}
            <div class="order-2 lg:order-1 space-y-8">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-3 rounded-full border border-indigo-200 bg-indigo-50/80 px-5 py-2 text-sm font-semibold text-indigo-700 shadow-lg backdrop-blur-xl transition-all hover:border-indigo-400 hover:bg-indigo-100 dark:border-indigo-500/30 dark:bg-white/5 dark:text-indigo-300 dark:hover:border-indigo-400/50 dark:hover:bg-white/10">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    </span>
                    Sistem Informasi HIMANIKKA
                </div>

                {{-- Headline --}}
                <div class="space-y-4">
                    <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl lg:text-6xl xl:text-7xl dark:text-white">
                        Selamat Datang di
                        <span class="relative mt-3 block bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                            HIMANIKKA
                        </span>
                    </h1>

                    <p class="max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-300">
                        Portal resmi <span class="font-semibold text-indigo-600 dark:text-indigo-400">Himpunan Mahasiswa Teknik Informatika</span> 
                        Universitas Pahlawan Tuanku Tambusai — pusat informasi kegiatan, pendaftaran, aspirasi, 
                        dan arsip organisasi mahasiswa teknik informatika.
                    </p>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('auth.register') }}"
                       class="group inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-4 font-semibold text-white shadow-xl shadow-indigo-500/30 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/40">
                        Bergabung Sekarang
                        <svg class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>

                    <a href="#tentang_kami"
                       class="group inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white/80 px-8 py-4 font-semibold text-slate-700 shadow-lg backdrop-blur-xl transition-all duration-300 hover:border-indigo-400 hover:bg-white hover:text-indigo-600 dark:border-slate-500/40 dark:bg-white/5 dark:text-slate-200 dark:hover:border-indigo-400/60 dark:hover:bg-white/10 dark:hover:text-white">
                        Jelajahi
                        <svg class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>

                {{-- Stats - Enhanced with real-time data --}}
                <div class="hero-stats-grid grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
                    @php
                        $stats = [
                            ['value' => $count['user'] ?? 0, 'label' => 'Mahasiswa', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                            ['value' => $count['struktur'] ?? 0, 'label' => 'Pengurus', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0zm-12 0a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                            ['value' => $count['acara'] ?? 0, 'label' => 'Kegiatan', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z'],
                            ['value' => $count['berita'] ?? 0, 'label' => 'Berita', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z'],
                            ['value' => $count['pendaftaran'] ?? 0, 'label' => 'Pendaftaran', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['value' => $count['pembayaran'] ?? 0, 'label' => 'Pembayaran', 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                            ['value' => $count['aspirasi'] ?? 0, 'label' => 'Aspirasi', 'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z'],
                            ['value' => $count['dokumentasi'] ?? 0, 'label' => 'Dokumentasi', 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:border-indigo-400 hover:shadow-xl sm:p-5 dark:border-white/10 dark:bg-white/5 dark:hover:border-indigo-400/30 dark:hover:bg-white/10">
                        <div class="absolute -right-4 -top-4 h-12 w-12 rounded-full bg-indigo-100 blur-xl transition-all duration-300 group-hover:bg-indigo-200 dark:bg-indigo-500/10 dark:group-hover:bg-indigo-400/20"></div>
                        <svg class="mx-auto mb-2 h-5 w-5 text-indigo-500 sm:h-6 sm:w-6 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
                        </svg>
                        <div class="text-xl font-extrabold text-slate-900 sm:text-2xl dark:text-white">{{ $stat['value'] }}</div>
                        <div class="text-[11px] font-medium text-slate-500 sm:text-xs dark:text-slate-400">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                    @if(isset($totalPemasukan) && $totalPemasukan > 0)
                    <div class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-center backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:border-emerald-300 hover:bg-emerald-100 sm:p-5 col-span-2 sm:col-span-4 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:hover:border-emerald-400/50 dark:hover:bg-emerald-500/20">
                        <div class="flex items-center justify-center gap-3">
                            <svg class="h-5 w-5 text-emerald-500 sm:h-6 sm:w-6 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <div class="text-lg font-extrabold text-emerald-600 sm:text-xl dark:text-emerald-300">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                                <div class="text-[11px] font-medium text-emerald-600/80 sm:text-xs dark:text-emerald-400/80">Total Pemasukan Organisasi</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: Slideshow --}}
            <div class="relative order-1 lg:order-2">
                <div class="absolute -inset-6 -z-10 rounded-[3rem] bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 blur-3xl"></div>

                <div
                    x-data="{
                        current: 0,
                        slides: @js($slides),
                        timer: null,
                        next() { if (!this.slides.length) return; this.current = (this.current + 1) % this.slides.length },
                        prev() { if (!this.slides.length) return; this.current = (this.current - 1 + this.slides.length) % this.slides.length }
                    }"
                    x-init="if (slides.length > 1) timer = setInterval(() => next(), 5000)"
                    x-on:mouseenter="if (timer) clearInterval(timer)"
                    x-on:mouseleave="if (slides.length > 1) timer = setInterval(() => next(), 5000)"
                    class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl shadow-indigo-500/10 backdrop-blur-xl dark:border-white/20 dark:bg-white/10">

                    <div class="relative h-[400px] overflow-hidden rounded-[1.5rem] bg-gradient-to-br from-slate-100 to-slate-200 lg:h-[500px] dark:from-slate-800 dark:to-slate-900">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div
                                x-show="current === index"
                                x-transition:enter="transition ease-out duration-700"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute inset-0">
                                <img :src="slide.image" :alt="slide.title" class="h-full w-full object-cover" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white lg:p-8">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-bold uppercase backdrop-blur-md"
                                          x-text="slide.type"
                                          :class="slide.type === 'Acara' ? 'bg-emerald-500/80' : 'bg-rose-500/80'"></span>
                                    <h3 class="mt-3 text-xl font-bold lg:text-2xl" x-text="slide.title"></h3>
                                    <p class="mt-2 text-sm text-white/80" x-text="slide.desc"></p>
                                </div>
                            </div>
                        </template>
                        <div x-show="slides.length === 0" class="flex h-full items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-700">
                            <p class="text-lg font-semibold text-white">Belum ada data</p>
                        </div>
                    </div>

                    {{-- Navigation Arrows --}}
                    <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-3 text-slate-700 shadow-2xl backdrop-blur-xl transition-all hover:bg-white hover:scale-110 dark:bg-white/20 dark:text-white dark:hover:bg-white/30">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-3 text-slate-700 shadow-2xl backdrop-blur-xl transition-all hover:bg-white hover:scale-110 dark:bg-white/20 dark:text-white dark:hover:bg-white/30">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Dots --}}
                    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            <span x-text="slides.length ? current + 1 : 0"></span>/<span x-text="slides.length"></span>
                        </div>
                        <div class="flex gap-2">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="current = index"
                                    :class="current === index ? 'bg-indigo-500 w-8 shadow-lg' : 'bg-slate-500/50 w-2 hover:bg-slate-400'"
                                    class="h-2 rounded-full transition-all duration-300"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Down Indicator --}}
    <div class="absolute bottom-6 left-1/2 z-10 -translate-x-1/2 animate-bounce">
        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>

{{-- ============================================================ --}}
{{-- SEPARATOR 1 --}}
{{-- ============================================================ --}}
<div class="scroll-reveal reveal-fade relative flex items-center justify-center py-8" data-reveal-delay="0.1">
    <div class="w-full max-w-4xl border-t border-slate-300 dark:border-slate-700"></div>
    <span class="absolute bg-white px-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-950 dark:text-slate-400">Tentang Kami</span>
</div>

{{-- ============================================================ --}}
{{-- TENTANG KAMI SECTION --}}
{{-- ============================================================ --}}
<section id="tentang_kami" class="scroll-reveal reveal-up relative overflow-hidden bg-gradient-to-b from-white to-slate-50 py-24 dark:from-slate-950 dark:to-slate-900" data-reveal-delay="0.1">
    @include('tentang_kami')
</section>

{{-- ============================================================ --}}
{{-- SEPARATOR 2 --}}
{{-- ============================================================ --}}
<div class="scroll-reveal reveal-fade relative flex items-center justify-center py-8" data-reveal-delay="0.1">
    <div class="w-full max-w-4xl border-t border-slate-300 dark:border-slate-700"></div>
    <span class="absolute bg-slate-50 px-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-900 dark:text-slate-400">Struktur Organisasi</span>
</div>

{{-- ============================================================ --}}
{{-- STRUKTUR SECTION --}}
{{-- ============================================================ --}}
<section id="struktur" class="scroll-reveal reveal-up relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-24 dark:from-slate-900 dark:to-slate-950" data-reveal-delay="0.15">
    @include('struktur')
</section>

{{-- ============================================================ --}}
{{-- SEPARATOR 3 --}}
{{-- ============================================================ --}}
<div class="scroll-reveal reveal-fade relative flex items-center justify-center py-8" data-reveal-delay="0.1">
    <div class="w-full max-w-4xl border-t border-slate-300 dark:border-slate-700"></div>
    <span class="absolute bg-white px-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-950 dark:text-slate-400">Kegiatan & Acara</span>
</div>

{{-- ============================================================ --}}
{{-- ACARA SECTION --}}
{{-- ============================================================ --}}
<section id="acara" class="scroll-reveal reveal-up relative overflow-hidden bg-gradient-to-b from-white to-slate-50 py-24 dark:from-slate-950 dark:to-slate-900" data-reveal-delay="0.1">
    @include('acara')
</section>

{{-- ============================================================ --}}
{{-- SEPARATOR 4 --}}
{{-- ============================================================ --}}
<div class="scroll-reveal reveal-fade relative flex items-center justify-center py-8" data-reveal-delay="0.1">
    <div class="w-full max-w-4xl border-t border-slate-300 dark:border-slate-700"></div>
    <span class="absolute bg-slate-50 px-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-900 dark:text-slate-400">Berita & Informasi</span>
</div>

{{-- ============================================================ --}}
{{-- BERITA SECTION --}}
{{-- ============================================================ --}}
<section id="berita" class="scroll-reveal reveal-up relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-24 dark:from-slate-950 dark:to-slate-900" data-reveal-delay="0.1">
    @include('berita')
</section>

{{-- ============================================================ --}}
{{-- SEPARATOR 5 --}}
{{-- ============================================================ --}}
<div class="scroll-reveal reveal-fade relative flex items-center justify-center py-8" data-reveal-delay="0.1">
    <div class="w-full max-w-4xl border-t border-slate-300 dark:border-slate-700"></div>
    <span class="absolute bg-white px-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-950 dark:text-slate-400">Aspirasi & Masukan</span>
</div>

{{-- ============================================================ --}}
{{-- ASPIRASI SECTION --}}
{{-- ============================================================ --}}
<section id="aspirasi" class="scroll-reveal reveal-up relative overflow-hidden bg-white py-24 dark:bg-slate-950" data-reveal-delay="0.1">
    @include('aspirasi')
</section>

{{-- FOOTER is auto-included from layouts/partials/footer.blade.php via the app layout. --}}

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
<style>
@keyframes gradient { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

/* Smooth Scroll Reveal */
.scroll-reveal {
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.scroll-reveal.reveal-up {
    transform: translateY(50px);
}

.scroll-reveal.reveal-down {
    transform: translateY(-50px);
}

.scroll-reveal.reveal-left {
    transform: translateX(-50px);
}

.scroll-reveal.reveal-right {
    transform: translateX(50px);
}

.scroll-reveal.reveal-fade {
    transform: none;
}

.scroll-reveal.visible {
    opacity: 1;
    transform: translate(0, 0);
}

.scroll-reveal-child > * {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.scroll-reveal-child.visible > *:nth-child(1) { opacity: 1; transform: translateY(0); transition-delay: 0.05s; }
.scroll-reveal-child.visible > *:nth-child(2) { opacity: 1; transform: translateY(0); transition-delay: 0.1s; }
.scroll-reveal-child.visible > *:nth-child(3) { opacity: 1; transform: translateY(0); transition-delay: 0.15s; }
.scroll-reveal-child.visible > *:nth-child(4) { opacity: 1; transform: translateY(0); transition-delay: 0.2s; }
.scroll-reveal-child.visible > *:nth-child(5) { opacity: 1; transform: translateY(0); transition-delay: 0.25s; }
.scroll-reveal-child.visible > *:nth-child(6) { opacity: 1; transform: translateY(0); transition-delay: 0.3s; }
.scroll-reveal-child.visible > *:nth-child(7) { opacity: 1; transform: translateY(0); transition-delay: 0.35s; }
.scroll-reveal-child.visible > *:nth-child(8) { opacity: 1; transform: translateY(0); transition-delay: 0.4s; }
.scroll-reveal-child.visible > *:nth-child(9) { opacity: 1; transform: translateY(0); transition-delay: 0.45s; }
.scroll-reveal-child.visible > *:nth-child(10) { opacity: 1; transform: translateY(0); transition-delay: 0.5s; }

/* Transparent Navbar on Hero — only in dark mode */
/* In light mode, navbar keeps its default semi-transparent white bg */
html.dark[data-nav-at-hero="true"] .navbar {
    background: transparent !important;
    border-bottom-color: transparent !important;
    box-shadow: none !important;
}

/* Dark mode: white text on dark hero */
html.dark[data-nav-at-hero="true"] .navbar .navbar-logo {
    color: white !important;
}
html.dark[data-nav-at-hero="true"] .navbar .navbar-logo:hover {
    color: rgba(255,255,255,0.8) !important;
}

html.dark[data-nav-at-hero="true"] .navbar .navbar-link {
    color: rgba(255, 255, 255, 0.85) !important;
}
html.dark[data-nav-at-hero="true"] .navbar .navbar-link:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: white !important;
}

html.dark[data-nav-at-hero="true"] .navbar .navbar-icon {
    color: rgba(255, 255, 255, 0.75) !important;
}
html.dark[data-nav-at-hero="true"] .navbar .navbar-icon:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: white !important;
}

html.dark[data-nav-at-hero="true"] .navbar .navbar-auth {
    color: rgba(255,255,255,0.9) !important;
}
html.dark[data-nav-at-hero="true"] .navbar .navbar-auth:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: white !important;
}

html.dark[data-nav-at-hero="true"] .navbar .navbar-btn {
    box-shadow: 0 4px 14px rgba(255,255,255,0.15) !important;
}
html.dark[data-nav-at-hero="true"] .navbar .navbar-btn:hover {
    box-shadow: 0 6px 20px rgba(255,255,255,0.2) !important;
}

/* When scrolled past hero, navbar returns to defaults via CSS reset */

@media (prefers-reduced-motion: reduce) {
    .scroll-reveal, .scroll-reveal-child > * {
        opacity: 1;
        transform: none;
        transition: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === NAVBAR TRANSPARENCY ON SCROLL ===
    const heroSection = document.getElementById('hero_section');
    if (heroSection) {
        const html = document.documentElement;
        
        function updateNavbarState() {
            const heroBottom = heroSection.offsetTop + heroSection.offsetHeight - 80;
            html.dataset.navAtHero = window.scrollY < heroBottom ? 'true' : 'false';
        }
        
        updateNavbarState();
        window.addEventListener('scroll', updateNavbarState, { passive: true });
        window.addEventListener('resize', updateNavbarState, { passive: true });
    }

    // === SCROLL REVEAL ANIMATIONS ===
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.revealDelay || 0;
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, delay * 1000);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });

    document.querySelectorAll('.scroll-reveal-child').forEach(el => {
        observer.observe(el);
    });

    // === STAGGERED STATS ANIMATION ===
    const statsGrid = document.querySelector('.hero-stats-grid');
    if (statsGrid) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const items = entry.target.querySelectorAll(':scope > div');
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 100 + index * 80);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        statsGrid.querySelectorAll(':scope > div').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
        });
        statsObserver.observe(statsGrid);
    }

    // === SMOOTH SCROLL FOR ANCHOR LINKS ===
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.pushState(null, '', href);
            }
        });
    });
});
</script>
@endsection
