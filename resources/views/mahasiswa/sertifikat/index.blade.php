@extends('Mahasiswa.layouts.app')

@section('title', 'Sertifikat Peserta Acara')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-950 dark:to-slate-900 py-12">
    <div class="max-w-6xl mx-auto px-4">
        {{-- Header --}}
        <div class="mb-12 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-5 py-2 text-sm font-semibold text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Sertifikat Digital
            </div>
            <h1 class="mt-6 text-4xl sm:text-5xl font-black text-slate-900 dark:text-white">
                Sertifikat <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Peserta</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-600 dark:text-slate-400">
                Unduh sertifikat untuk acara yang sudah Anda ikuti dan selesaikan.
            </p>
        </div>

        {{-- Daftar Sertifikat --}}
        @if($pendaftarans->count() > 0)
            <div class="grid gap-6 md:grid-cols-2">
                @foreach($pendaftarans as $pendaftaran)
                    @php $acara = $pendaftaran->acaras; @endphp
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 shadow-lg border border-slate-200/60 dark:border-slate-700/50 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-start gap-5">
                                {{-- Icon --}}
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                        {{ $acara->name_acara ?? 'Acara' }}
                                    </h3>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d F Y') : '-' }}
                                    </p>

                                    <div class="mt-4 flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Peserta Aktif
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ $acara->tempat ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-6 flex gap-3">
                                <a href="{{ route('Mahasiswa.sertifikat.show', $pendaftaran->id) }}"
                                   target="_blank"
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat & Cetak
                                </a>
                                <a href="{{ route('Mahasiswa.sertifikat.show', $pendaftaran->id) }}?print=1"
                                   target="_blank"
                                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition"
                                   title="Cetak langsung">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-slate-100 dark:bg-slate-800">
                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-bold text-slate-900 dark:text-white">Belum Ada Sertifikat</h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                    Sertifikat akan tersedia setelah Anda mengikuti acara dan status pendaftaran Anda diterima.
                </p>
                <a href="{{ route('Mahasiswa.acara.index') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-lg">
                    Lihat Acara Tersedia
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
