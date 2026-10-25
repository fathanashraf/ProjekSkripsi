@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Aspirasi HIMANIKKA')
@section('pageTitle', 'Aspirasi')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-cyan-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium ring-1 ring-white/20">
                    Sistem Aspirasi HIMANIKKA
                </span>

                <h1 class="mt-3 text-3xl font-bold">
                    Monitoring Aspirasi
                </h1><p class="mt-2 text-sm text-white/80">
                        Monitoring seluruh aspirasi, kritik, saran dan masukan mahasiswa.
                    </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="button"
                    @click="$store.modal.open(@js($aspirasiFormPayload ?? []))"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-100"
                >
                    <span class="text-base">+</span>
                    Tambah Aspirasi
                </button>
            </div>

            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                <p class="text-xs text-white/70">Total Aspirasi</p>
                <h2 class="text-3xl font-bold">{{ $stats['total'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-4">
        <div class="card p-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Aspirasi</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] ?? 0 }}</h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-amber-500">Menunggu</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['pending'] ?? 0 }}</h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-blue-500">Diproses</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['proses'] ?? 0 }}</h3>
        </div>

        <div class="card p-5">
            <p class="text-sm text-green-500">Selesai</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['selesai'] ?? 0 }}</h3>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Data Aspirasi Mahasiswa</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Acara</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Masukkan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($aspirasis as $aspirasi)
                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            {{-- Pengirim --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-white">{{ $aspirasi->user->name ?? 'Guest' }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">{{ $aspirasi->user->email ?? '-' }}</div>
                            </td>

                            {{-- Acara --}}
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-200">
                                @if ($aspirasi->acaras_id)
                                    {{ $aspirasi->acara?->name_acara ?? '-' }}
                                @elseif ($aspirasi->beritas_id)
                                    {{ $aspirasi->berita?->name_berita ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $aspirasi->created_at->format('d M Y') }}</td>

                            {{-- Jenis --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                @if ($aspirasi->like)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">Like</span>
                                @elseif ($aspirasi->dislike)
                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 dark:bg-rose-500/20 dark:text-rose-300">Dislike</span>
                                @elseif ($aspirasi->Masukkan)
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">Masukkan</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500 dark:bg-slate-700 dark:text-slate-300">-</span>
                                @endif
                            </td>

                            {{-- Isi Aspirasi --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $aspirasi->Masukkan ?? $aspirasi->isi ?? '-' }}</td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($aspirasi->status == 'pending')
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">Pending</span>
                                @elseif($aspirasi->status == 'proses')
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">Diproses</span>
                                @else
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-500/20 dark:text-green-300">Selesai</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <button
                                    type="button"
                                    @click="$store.modal.open({
                                        mode: 'detail',
                                        title: 'Detail Aspirasi',
                                        detail: {
                                            pengirim: '{{ $aspirasi->user->name ?? 'Guest' }}',
                                            email: '{{ $aspirasi->user->email ?? '-' }}',
                                            acara: '{{ $aspirasi->acara?->name_acara ?? ($aspirasi->berita?->name_berita ?? '-') }}',
                                            jenis: '{{ $aspirasi->like ? 'Like' : ($aspirasi->dislike ? 'Dislike' : ($aspirasi->Masukkan ? 'Masukkan' : '-')) }}',
                                            like: '{{ $aspirasi->like ?? '-' }}',
                                            dislike: '{{ $aspirasi->dislike ?? '-' }}',
                                            Masukkan: '{{ $aspirasi->Masukkan ?? '-' }}',
                                            isi: '{{ $aspirasi->isi ?? '-' }}',
                                            tanggal: '{{ $aspirasi->created_at->format('d M Y H:i') }}',
                                            status: '{{ ucfirst($aspirasi->status ?? '-') }}'
                                        },
                                        fields: [
                                            {key: 'pengirim', label: 'Pengirim', type: 'text'},
                                            {key: 'email', label: 'Email', type: 'text'},
                                            {key: 'acara', label: 'Acara/Berita', type: 'text'},
                                            {key: 'jenis', label: 'Jenis', type: 'text'},
                                            {key: 'like', label: 'Like', type: 'textarea'},
                                            {key: 'dislike', label: 'Dislike', type: 'textarea'},
                                            {key: 'Masukkan', label: 'Masukkan', type: 'textarea'},
                                            {key: 'isi', label: 'Isi', type: 'textarea'},
                                            {key: 'tanggal', label: 'Tanggal', type: 'text'},
                                            {key: 'status', label: 'Status', type: 'text'}
                                        ]
                                    })"
                                    class="inline-flex items-center gap-2 rounded-xl bg-blue-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-600"
                                >
                                    Detail
                                </button>

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'form',
                                            title: 'Edit Aspirasi',
                                            formAction: '{{ route('admin.aspirasi.update', $aspirasi->id) }}',
                                            method: 'POST',
                                            extraMethod: 'PUT',
                                            fields: [
                                                {name: 'users_id', label: 'Pengirim', type: 'select', options: @js($users->map(fn($u) => ['value' => $u->id, 'label' => $u->name]))},
                                                {name: 'acaras_id', label: 'Acara', type: 'select', options: @js($acaras->map(fn($a) => ['value' => $a->id, 'label' => $a->name_acara]))},
                                                {name: 'beritas_id', label: 'Berita', type: 'select', options: @js($beritas->map(fn($b) => ['value' => $b->id, 'label' => $b->name_berita]))},
                                                {name: 'like', label: 'Like', type: 'text'},
                                                {name: 'dislike', label: 'Dislike', type: 'text'},
                                                {name: 'Masukkan', label: 'Masukkan', type: 'textarea', full: true},
                                                {name: 'status', label: 'Status', type: 'select', options: [
                                                    {value: 'pending', label: 'Pending'},
                                                    {value: 'proses', label: 'Diproses'},
                                                    {value: 'selesai', label: 'Selesai'}
                                                ]}
                                            ],
                                            data: {
                                                users_id: @js($aspirasi->users_id),
                                                acaras_id: @js($aspirasi->acaras_id),
                                                beritas_id: @js($aspirasi->beritas_id),
                                                like: @js($aspirasi->like),
                                                dislike: @js($aspirasi->dislike),
                                                Masukkan: @js($aspirasi->Masukkan),
                                                status: @js($aspirasi->status)
                                            }
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'confirm',
                                            title: 'Hapus Aspirasi',
                                            message: 'Data aspirasi ini akan dihapus.',
                                            action: () => document.getElementById('delete-aspirasi-{{ $aspirasi->id }}').submit()
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-rose-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-rose-600"
                                    >
                                        Hapus
                                    </button>

                                    <form id="delete-aspirasi-{{ $aspirasi->id }}" action="{{ route('admin.aspirasi.destroy', $aspirasi->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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