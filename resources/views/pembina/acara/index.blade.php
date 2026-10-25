@extends('pembina.layouts.app')

@section('title', 'Beranda Acara HIMANIKKA')

@section('content')

<div x-data="{
    modalOpen: false,
    modalMode: '',
    modalTitle: '',
    modalData: {}
}" class="space-y-6">

    <!-- Header -->
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="max-w-3xl">
            <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                Dashboard Pembina HIMANIKKA
            </div>
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                Monitoring Acara HIMANIKKA
            </h1>
            <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                Pantau seluruh kegiatan dan perkembangan acara yang dilaksanakan oleh HIMANIKKA.
            </p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Acara</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['total'] ?? 0 }}
            </h2>
        </div>

        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Acara Aktif</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['approved'] ?? 0 }}
            </h2>
        </div>

        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Selesai</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['selesai'] ?? 0 }}
            </h2>
        </div>

        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Peserta</p>
            <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['total_peserta'] ?? 0 }}
            </h2>
        </div>
    </div>

    <!-- Tabel Acara -->
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Daftar Acara HIMANIKKA
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Informasi kegiatan berdasarkan acara.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Acara</th>
                        <th class="px-6 py-4">Penanggung Jawab</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Tempat</th>
                        <th class="px-6 py-4">Peserta</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($acaras as $acara)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <!-- Acara -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900 dark:text-white">
                                    {{ $acara->name_acara }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    ID : {{ $acara->id }}
                                </div>
                            </td>

                            <!-- PJ -->
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                {{ $acara->user->name ?? '-' }}
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                {{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }}
                            </td>

                            <!-- Tempat -->
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                {{ $acara->tempat ?? '-' }}
                            </td>

                            <!-- Peserta -->
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                                    {{ $acara->pendaftarans_count }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        @if($acara->status === 'approved')
                                            bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @elseif($acara->status === 'diajukan')
                                            bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300
                                        @elseif($acara->status === 'rejected')
                                            bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                    {{ ucfirst($acara->status ?? '-') }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Lihat Acara -->
                                    <button
                                        @click="modalOpen = true; modalMode = 'info'; modalTitle = 'Detail Acara'; modalData = {
                                            name_acara: @js($acara->name_acara),
                                            user_name: @js($acara->user->name ?? '-'),
                                            tanggal: @js($acara->tanggal ? \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') : '-'),
                                            tempat: @js($acara->tempat ?? '-'),
                                            peserta: {{ $acara->pendaftarans_count }},
                                            thumnail: @js($acara->thumnail ? asset('storage/' . $acara->thumnail) : '')
                                        }"
                                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                    >
                                        Lihat
                                    </button>

                                    @if ($acara->status === 'diajukan')
                                        <!-- Konfirmasi -->
                                        <form action="{{ route('pembina.acara.approve', $acara->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                onclick="return confirm('Konfirmasi Acara\n\nAcara ini akan dikonfirmasi.\n\nYa | Batal')"
                                                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700"
                                            >
                                                Konfirmasi
                                            </button>
                                        </form>

                                        <!-- Tolak -->
                                        <form action="{{ route('pembina.acara.reject', $acara->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                onclick="return confirm('Tolak Acara\n\nAcara ini akan ditolak.\n\nYa | Batal')"
                                                class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700"
                                            >
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                                    Belum ada acara
                                </h3>
                                <p class="text-sm text-slate-500">
                                    Data acara belum tersedia.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail Acara -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
         @click.away="modalOpen = false"
         x-cloak>
        <div class="relative w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
             @click.away="modalOpen = false">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Detail Informasi Acara</p>
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
            <div class="p-6 space-y-4">
                <!-- Thumbnail Image -->
                <template x-if="modalData.thumnail">
                    <div class="mb-4 rounded-2xl overflow-hidden shadow-lg">
                        <img :src="modalData.thumnail" 
                             alt="Thumbnail Acara" 
                             class="w-full h-48 object-cover">
                    </div>
                </template>

                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Nama Acara:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.name_acara"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Penanggung Jawab:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.user_name"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Tanggal:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.tanggal"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Tempat:</span>
                    <p class="text-slate-700 dark:text-slate-300" x-text="modalData.tempat"></p>
                </div>
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">Jumlah Peserta:</span>
                    <p class="text-slate-700 dark:text-slate-300">
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 dark:bg-blue-950/40 dark:text-blue-300" 
                              x-text="modalData.peserta + ' Orang'"></span>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                <button type="button" 
                        @click="modalOpen = false"
                        class="btn-secondary w-full justify-center">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

@endsection