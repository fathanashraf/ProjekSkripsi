@extends('pembina.layouts.app')

@section('title', 'Monitoring Aspirasi HIMANIKKA')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-cyan-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium ring-1 ring-white/20">
                    Sistem Aspirasi HIMANIKKA
                </span>

                <h1 class="mt-3 text-3xl font-bold">
                    Monitoring Aspirasi
                </h1>

                <p class="mt-2 text-sm text-white/80">
                    Monitoring seluruh aspirasi, kritik, saran dan masukan mahasiswa.
                </p>
            </div>

            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                <p class="text-xs text-white/70">
                    Total Aspirasi
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $stats['total'] ?? 0 }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-4">

        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Aspirasi</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['total'] ?? 0 }}
            </h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-amber-500">Menunggu</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['pending'] ?? 0 }}
            </h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-blue-500">Diproses</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['proses'] ?? 0 }}
            </h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-green-500">Selesai</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $stats['selesai'] ?? 0 }}
            </h3>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="card p-0 overflow-hidden">

        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Data Aspirasi Mahasiswa
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Sumber</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Masukkan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                    @forelse($aspirasis as $aspirasi)

                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-white">
                                    {{ $aspirasi->user->name ?? 'Anonim' }}
                                </div>

                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $aspirasi->user->email ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if($aspirasi->like)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        LIKE
                                    </span>
                                @elseif($aspirasi->dislike)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/20 dark:text-red-300">
                                        DISLIKE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        MASUKKAN
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($aspirasi->acaras_id)
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                        ACARA
                                    </span>
                                @elseif($aspirasi->beritas_id)
                                    <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-700 dark:bg-purple-500/20 dark:text-purple-300">
                                        BERITA
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $aspirasi->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $aspirasi->Masukkan ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = match ($aspirasi->status) {
                                        'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                        'proses' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                        'selesai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                        default => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                                    };
                                @endphp
                                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ ucfirst($aspirasi->status ?? '-') }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap justify-end gap-2">

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail Aspirasi',
                                            detail: {
                                                pengirim: @js($aspirasi->user->name ?? 'Anonim'),
                                                email: @js($aspirasi->user->email ?? '-'),
                                                sumber: @js($aspirasi->acara?->name_acara ?? $aspirasi->berita?->name_berita ?? '-'),
                                                like: @js($aspirasi->like ?? '-'),
                                                dislike: @js($aspirasi->dislike ?? '-'),
                                                Masukkan: @js($aspirasi->Masukkan ?? '-'),
                                                tanggal: @js($aspirasi->created_at->format('d M Y H:i')),
                                                status: @js(ucfirst($aspirasi->status ?? '-'))
                                            },
                                            fields: [
                                                {key: 'pengirim', label: 'Pengirim', type: 'text'},
                                                {key: 'email', label: 'Email', type: 'text'},
                                                {key: 'sumber', label: 'Acara/Berita', type: 'text'},
                                                {key: 'like', label: 'Like', type: 'textarea'},
                                                {key: 'dislike', label: 'Dislike', type: 'textarea'},
                                                {key: 'Masukkan', label: 'Masukkan', type: 'textarea'},
                                                {key: 'tanggal', label: 'Tanggal', type: 'text'},
                                                {key: 'status', label: 'Status', type: 'text'}
                                            ]
                                        })"
                                        class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>

                                    @if ($aspirasi->status !== 'proses')
                                        <form action="{{ route('pembina.aspirasi.proses', $aspirasi->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                onclick="return confirm('Proses aspirasi ini?')"
                                                class="inline-flex items-center rounded-xl bg-blue-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-600"
                                            >
                                                Proses
                                            </button>
                                        </form>
                                    @endif

                                    @if ($aspirasi->status !== 'selesai')
                                        <form action="{{ route('pembina.aspirasi.selesai', $aspirasi->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                onclick="return confirm('Tandai persiapan ini sebagai selesai?')"
                                                class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700"
                                            >
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('pembina.aspirasi.destroy', $aspirasi->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Hapus aspirasi ini?')"
                                            class="inline-flex items-center rounded-xl bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-500 dark:text-slate-400">
                                Belum ada aspirasi yang masuk.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection