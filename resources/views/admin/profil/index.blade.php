@extends('admin.layouts.app')

@section('title', $title ?? 'Dashboard Profil HIMANIKKA')
@section('pageTitle', 'Profil')

@section('content')
<div
    class="space-y-6"

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

            <div class="flex flex-wrap items-center gap-3">
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah Profil',
                        formAction: '{{ route('admin.profil.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',
                        fields: [
                            { name: 'name_instansi', label: 'Nama Instansi', type: 'text', full: true },
                            { name: 'singkatan', label: 'Singkatan', type: 'text' },
                            { name: 'sejarah', label: 'Sejarah', type: 'textarea' },
                            { name: 'alamat', label: 'Alamat', type: 'textarea' },
                            { name: 'logo', label: 'Logo', type: 'file' },
                            { name: 'tahun_berdiri', label: 'Tahun Berdiri', type: 'text' },
                            { name: 'visi', label: 'Visi', type: 'textarea' },
                            { name: 'misi', label: 'Misi', type: 'textarea' },
                            { name: 'tujuan', label: 'Tujuan', type: 'textarea' },
                            { name: 'fungsi', label: 'Fungsi', type: 'textarea' },
                            { name: 'ad_art', label: 'AD/ART', type: 'file' },
                            {name: 'hymne_teknik', label: 'Hymne Teknik', type: 'file'},
                            { name: 'mars_mahasiswa', label: 'Mars Mahasiswa', type: 'file' },
                        ],
                        data: {
                            name_instansi: '',
                            singkatan: '',
                            sejarah: '',
                            alamat: '',
                            logo: '',
                            tahun_berdiri: '',
                            visi: '',
                            misi: '',
                            tujuan: '',
                            fungsi: '',
                            ad_art: '',
                            hymne_teknik: '',
                            mars_mahasiswa: ''
                        }
                    })"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:bg-slate-100 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-white/50"
                >
                    <span class="text-base leading-none">+</span>
                    <span>Tambah Profil</span>
                </button>

                @if($profil->id)
                <button
    type="button"
    @click="$store.modal.open({
        mode: 'form',
        title: 'Edit Profil',
        formAction: '{{ route('admin.profil.update', $profil->id) }}',
        method: 'POST',
        extraMethod: 'PUT',
        enctype: 'multipart/form-data',
        fields: [
                            { name: 'name_instansi', label: 'Nama Instansi', type: 'text', full: true },
                            { name: 'singkatan', label: 'Singkatan', type: 'text' },
                            { name: 'sejarah', label: 'Sejarah', type: 'textarea' },
                            { name: 'alamat', label: 'Alamat', type: 'textarea' },
                            { name: 'logo', label: 'Logo', type: 'file' },
                            { name: 'tahun_berdiri', label: 'Tahun Berdiri', type: 'text' },
                            { name: 'visi', label: 'Visi', type: 'textarea' },
                            { name: 'misi', label: 'Misi', type: 'textarea' },
                            { name: 'tujuan', label: 'Tujuan', type: 'textarea' },
                            { name: 'fungsi', label: 'Fungsi', type: 'textarea' },
                            { name: 'ad_art', label: 'AD/ART', type: 'file' },
                            {name: 'hymne_teknik', label: 'Hymne Teknik', type: 'file'},
                            { name: 'mars_mahasiswa', label: 'Mars Mahasiswa', type: 'file' }
                        ],
                        data: {
                            name_instansi: @js($profil->name_instansi ?? ''),
                            singkatan: @js($profil->singkatan ?? ''),
                            sejarah: @js($profil->sejarah ?? ''),
                            alamat: @js($profil->alamat ?? ''),
                            logo: '',
                            tahun_berdiri: @js($profil->tahun_berdiri ?? ''),
                            visi: @js($profil->visi ?? ''),
                            misi: @js($profil->misi ?? ''),
                            tujuan: @js($profil->tujuan ?? ''),
                            fungsi: @js($profil->fungsi ?? ''),
                            ad_art: '',
                            hymne_teknik: '',
                            mars_mahasiswa: ''
                        }
    })"
    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:bg-slate-100 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-white/50"
>
    <span class="text-base leading-none">+</span>
    <span>Edit Profil</span>
</button>
                @endif
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
                <button type="button" @click="$store.modal.open({mode: 'detail', title: 'Sejarah', detail: {sejarah: @js($profil->sejarah ?? 'Data sejarah belum tersedia.')}, fields: [{key: 'sejarah', label: 'Sejarah', type: 'textarea'}]})" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
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
                    <button type="button" @click="$store.modal.open({mode: 'detail', title: 'Visi', detail: {visi: @js($profil->visi ?? 'Data visi belum tersedia.')}, fields: [{key: 'visi', label: 'Visi', type: 'textarea'}]})" class="w-full text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Visi</h2>
                            <span class="text-slate-400">...</span>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-3">
                            {{ $profil->visi ?? 'Data visi belum tersedia.' }}
                        </p>
                        <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                    </button>

                    <button type="button" @click="$store.modal.open({mode: 'detail', title: 'Misi', detail: {misi: @js($profil->misi ?? 'Data misi belum tersedia.')}, fields: [{key: 'misi', label: 'Misi', type: 'textarea'}]})" class="w-full text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
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
                <button type="button" @click="$store.modal.open({mode: 'detail', title: 'Tujuan', detail: {tujuan: @js($profil->tujuan ?? 'Data tujuan belum tersedia.')}, fields: [{key: 'tujuan', label: 'Tujuan', type: 'textarea'}]})" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Tujuan</h2>
                        <span class="text-slate-400">...</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300 line-clamp-4 whitespace-pre-line">{{ $profil->tujuan ?? 'Data tujuan belum tersedia.' }}</p>
                    <div class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat selengkapnya...</div>
                </button>

                <button type="button" @click="$store.modal.open({mode: 'detail', title: 'Fungsi', detail: {fungsi: @js($profil->fungsi ?? 'Data fungsi belum tersedia.')}, fields: [{key: 'fungsi', label: 'Fungsi', type: 'textarea'}]})" class="text-left rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
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
                    <a href="{{ !empty($profil->ad_art) ? Storage::url($profil->ad_art) : '#' }}" class="block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
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
</div>
@endsection