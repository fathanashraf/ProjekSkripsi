@extends('pembina.layouts.app')

@section('title', 'Halaman Persetujuan Laporan HIMANIKKA')

@section('content')

<div x-data="{
    modalOpen: false,
    modalMode: '',
    modalTitle: '',
    modalFormAction: '',
    modalMethod: '',
    modalFields: [],
    lapisanData: {}
}" class="space-y-6">

    <!-- Header -->
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <h1 class="text-3xl font-bold">Persetujuan Laporan</h1>
        <p class="mt-2 text-sm text-white/70">Kelola persetujuan laporan kegiatan HIMANIKKA.</p>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-950">
                    <tr class="text-left text-xs uppercase text-slate-500">
                        <th class="px-6 py-4 font-semibold">Acara</th>
                        <th class="px-6 py-4 font-semibold">Tujuan Acara</th>
                        <th class="px-6 py-4 font-semibold">Ketua Acara</th>
                        <th class="px-6 py-4 font-semibold">File</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($laporans as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <!-- Acara -->
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <img 
                                        src="{{ asset('storage/'.$item->acara->thumnail) }}" 
                                        class="h-12 w-12 rounded-xl object-cover shadow-sm" 
                                        alt="{{ $item->acara->name_acara }}"
                                    />
                                    
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                            {{ $item->acara->name_acara }}
                                        </p>
                                        
                                        <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                <path d="M7.5 3a.5.5 0 01.5.5v3h9v-3a.5.5 0 011 0v3h1.5a.5.5 0 010 1H6.5a.5.5 0 010-1H8v-3a.5.5 0 01.5-.5z"/>
                                                <path fill-rule="evenodd" d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $item->acara->tanggal ? \Carbon\Carbon::parse($item->acara->tanggal)->format('d M Y') : '-' }}
                                        </div>
                                        
                                        @if($item->acara->tempat)
                                            <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                                                </svg>
                                                {{ $item->acara->tempat }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Tujuan Acara -->
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ $item->acara->keterangan ?? '-' }}
                                </p>
                            </td>

                            <!-- Ketua Acara -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-slate-400">
                                        <path fill-rule="evenodd" d="M12 2.25a3 3 0 100 6 3 3 0 000-6zm0 2.25a.75.75 0 110 1.5.75.75 0 010-1.5zM7 8.25a3 3 0 014.5-.75.75.75 0 11.75 1.5v.75a3 3 0 013 3v7.5a3 3 0 01-3 3h-6a3 3 0 01-3-3v-7.5a3 3 0 013-3v-.75a.75.75 0 11.75-1.5A3 3 0 017 8.25z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $item->acara->user_id ? $item->acara->user->name : '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- File / PDF -->
                            <td class="px-6 py-4">
                                @if($item->status == 'approved' && $item->file)
                                    <a href="{{ asset('storage/'.$item->file) }}" 
                                        target="_blank"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-red-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        📕 PDF Tervalidasi
                                    </a>
                                @elseif($item->file)
                                    <a href="{{ asset('storage/'.$item->file) }}" 
                                        target="_blank"
                                        class="inline-flex items-center gap-1 rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                            <path fill-rule="evenodd" d="M19.25 5.75a.75.75 0 00-1.5 0v8.94l-3.47-3.47a.75.75 0 00-1.06 0l-5.25 5.25a.75.75 0 101.06 1.06l4.72-4.72 3.47 3.47v4.92a.75.75 0 001.5 0V6.5a.25.25 0 00-.25-.25h-11a.25.25 0 00-.25.25v11a.25.25 0 00.25.25h3a.75.75 0 000 1.5h-3A1.75 1.75 0 014.75 17.5V6.5A1.75 1.75 0 016.5 4.75h11a.75.75 0 01.75.75v11a.75.75 0 01-1.5 0V6.5a.25.25 0 00-.25-.25z" clip-rule="evenodd"/>
                                        </svg>
                                        Lihat File
                                    </a>
                                @elseif($item->status == 'approved')
                                    <span class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">✓ Disetujui</span>
                                @else
                                    <span class="text-sm text-slate-500 dark:text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($item->status == 'approved')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                        Disetujui
                                    </span>
                                @elseif($item->status == 'rejected')
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-900 dark:text-red-300">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ $item->status === 'diajukan' ? 'Diajukan' : $item->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                @if($item->status == 'diajukan')
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('pembina.laporan.approve', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007l5.44.82c1.165.176 1.654 1.494.775 2.298l-3.976 3.648l1.085 5.44c.23 1.165-.915 2.06-2.005 1.54L12 18.905l-5.019 2.558c-1.09.52-2.235-.375-2.005-1.54l1.085-5.44l-3.976-3.648c-.879-.804-.39-2.122.775-2.298l5.44-.82l2.082-5.007z"/>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>

                                        <button type="button"
                                            @click="modalOpen = true; modalMode = 'form'; modalTitle = 'Tolak Laporan'; modalFormAction = '{{ route('pembina.laporan.reject', $item->id) }}'; modalMethod = 'POST'; modalFields = [{name: 'catatan', label: 'Alasan Penolakan', type: 'textarea', required: true}];"
                                            class="inline-flex items-center gap-1 rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd" d="M21.75 6.75a.75.75 0 01-.75.75h-14.25l.97 9.19a.75.75 0 01-1.5.16l-.99-9.46h-1.5a.75.75 0 010-1.5h1.5l.99-2.96a.75.75 0 01.71-.54h12.57a.75.75 0 01.75.75v11.25a.75.75 0 01-1.5 0V6.75zM12 15a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3A.75.75 0 0112 15zm0-6a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3A.75.75 0 0112 9z"/>
                                            </svg>
                                            Tolak
                                        </button>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 text-sm text-slate-500 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12 text-slate-300 dark:text-slate-600">
                                        <path d="M6.25 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 20a2.25 2.25 0 002.25 2.25h14.5A2.25 2.25 0 0020.5 20v-2.14a2.25 2.25 0 00-.75-1.69l-4.5-3.75a2.25 2.25 0 00-2.75 0L1.5 16.17A2.25 2.25 0 00.75 17.86V20z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Belum ada laporan</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Laporan kegiatan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tolak Laporan -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
         @click.away="modalOpen = false"
         x-cloak>
        <div class="relative w-full max-w-xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
             @click.away="modalOpen = false">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-red-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Berikan alasan penolakan laporan</p>
                </div>
                <button type="button" 
                        @click="modalOpen = false" 
                        class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <form :action="modalFormAction" method="POST">
                    @csrf
                    <!-- Catatan -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 dark:text-white">
                            Alasan Penolakan
                        </label>
                        <textarea name="catatan" 
                                rows="4"
                                required
                                class="form-input"
                                placeholder="Jelaskan alasan penolakan laporan ini..."></textarea>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex gap-3">
                        <button type="button" 
                                @click="modalOpen = false"
                                class="btn-secondary w-full justify-center">
                            Batal
                        </button>
                        <button type="submit"
                                class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                            Tolak Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection