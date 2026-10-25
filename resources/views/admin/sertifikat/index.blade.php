@extends('admin.layouts.app')
@section('title', 'Sertifikat Peserta - HIMANIKKA')

@section('content')
<div class="space-y-6">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-teal-900 to-green-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Sertifikat Digital HIMANIKKA
                </div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    🏅 Sertifikat Peserta
                </h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola dan cetak sertifikat untuk peserta acara yang sudah diterima.
                </p>
            </div>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                Acara: <span class="text-emerald-600">
                    @foreach ($acara as $kegiatan)
                        {{ $kegiatan->name_acara }}
                    @endforeach
                </span>
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ $pendaftarans->count() }} peserta dengan status diterima
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Peserta</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($pendaftarans as $index => $p)
                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">{{ $p->users?->name ?? $p->nama_pendaftar ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $p->users?->NIM ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $p->users?->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('Mahasiswa.sertifikat.show', $p->id) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat Sertifikat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Belum ada peserta yang diterima untuk acara ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.acara.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
            ← Kembali ke Acara
        </a>
    </div>
</div>
@endsection
