@extends('pembina.layouts.app')

@section('title', $title ?? 'Dashboard Profil HIMANIKKA')
@section('pageTitle', 'Profil')

@section('content')
<div
    class="space-y-6"
    x-data="{
        open: false,
        title: '',
        content: '',
        setModal(title, content) {
            this.title = title
            this.content = content
            this.open = true
        }
    }"
>
    <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    {{ $profil->singkatan ?? 'Profil Organisasi' }}
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    {{ $profil->name_instansi ?? 'Dashboard Profil HIMANIKKA' }}
                </h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base line-clamp-3">
                    {{ \Illuminate\Support\Str::limit($profil->sejarah ?? 'Data profil belum diisi.', 180) }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Tentang Organisasi</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Instansi</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $profil->name_instansi ?? '-' }}</div>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Singkatan</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $profil->singkatan ?? '-' }}</div>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800 sm:col-span-2">
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Alamat</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $profil->alamat ?? '-' }}</div>
                    </div>
                    <!-- tahun berdiri -->
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Tahun Berdiri</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $profil->tahun_berdiri ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <button type="button" @click="setModal('Sejarah', @js($profil->sejarah ?? 'Data sejarah belum tersedia.'))" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Sejarah</h2>
                        <span class="text-slate-400">...</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-4">
                        {{ $profil->sejarah ?? 'Data sejarah belum tersedia.' }}
                    </p>
                    <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                </button>

                <div class="space-y-6">
                    <button type="button" @click="setModal('Visi', @js($profil->visi ?? 'Data visi belum tersedia.'))" class="w-full text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Visi</h2>
                            <span class="text-slate-400">...</span>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-3">
                            {{ $profil->visi ?? 'Data visi belum tersedia.' }}
                        </p>
                        <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                    </button>

                    <button type="button" @click="setModal('Misi', @js($profil->misi ?? 'Data misi belum tersedia.'))" class="w-full text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Misi</h2>
                            <span class="text-slate-400">...</span>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-4 whitespace-pre-line">
                            {{ $profil->misi ?? 'Data misi belum tersedia.' }}
                        </p>
                        <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                    </button>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <button type="button" @click="setModal('Tujuan', @js($profil->tujuan ?? 'Data tujuan belum tersedia.'))" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Tujuan</h2>
                        <span class="text-slate-400">...</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-4 whitespace-pre-line">{{ $profil->tujuan ?? 'Data tujuan belum tersedia.' }}</p>
                    <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                </button>

                <button type="button" @click="setModal('Fungsi', @js($profil->fungsi ?? 'Data fungsi belum tersedia.'))" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Fungsi</h2>
                        <span class="text-slate-400">...</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-4 whitespace-pre-line">{{ $profil->fungsi ?? 'Data fungsi belum tersedia.' }}</p>
                    <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                </button>

                
            </div>
        </div>

        <div class="space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Kebutuhan Organisasi</h2>
                <div class="mt-4 space-y-3">
                    <a href="{{ !empty($profil->AD_ART) ? Storage::url($profil->AD_ART) : '#' }}" class="block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        AD/ART
                    </a>
                    <a href="{{ !empty($profil->mars_mahasiswa) ? Storage::url($profil->mars_mahasiswa) : '#' }}" class="block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        Mars Mahasiswa
                    </a>
                    <a href="{{ !empty($profil->hymne_teknik) ? Storage::url($profil->hymne_teknik) : '#' }}" class="block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        Hymne Teknik
                    </a>
                </div>
            </div>

            <div class="space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Dokumen Organisasi</h2>
                <div class="mt-4 space-y-3">
                    <a href="{{ !empty($profil->logo) ? Storage::url($profil->logo) : '#' }}" class="block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        Logo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-[999] flex items-start justify-center overflow-y-auto p-4 sm:p-6 lg:p-8"
        @keydown.escape.window="open = false"
    >
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" @click="open = false"></div>

        <div
            x-show="open"
            x-transition.scale.origin.center
            class="relative z-[1000] my-auto flex w-full max-w-3xl max-h-[90vh] flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-slate-900"
        >
            <div class="shrink-0 flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Profil HIMANIKKA</p>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white" x-text="title"></h2>
                </div>

                <button
                    type="button"
                    @click="open = false"
                    class="flex h-10 w-10 items-center justify-center rounded-xl transition hover:bg-slate-100 dark:hover:bg-slate-800"
                >
                    <svg class="h-5 w-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <div class="rounded-2xl bg-slate-50 p-5 dark:bg-slate-800">
                    <div class="whitespace-pre-line text-sm leading-7 text-slate-700 dark:text-slate-300 sm:text-base" x-text="content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection