@extends('layouts.app')

@section('title', 'Pembayaran Pendaftaran')

@push('scripts')
@if($snapToken)
<script src="https://{{ config('midtrans.is_production') ? 'app.midtrans.com' : 'app.sandbox.midtrans.com' }}/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
document.getElementById('pay-snap')?.addEventListener('click', function() {
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            window.location.href = '{{ route('pembayaran.index') }}?status=success';
        },
        onPending: function(result) {
            alert('Pembayaran sedang diproses. Silakan selesaikan pembayaran Anda.');
        },
        onError: function(result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: function() {
        }
    });
});
</script>
@endif
@endpush

@section('content')
<section class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 py-16 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"
    x-data="{
        pembayaranOpen: false,
        existingStatus: '{{ $existingPembayaran?->status ?? 'belum_ada' }}',
        existingJenis: '{{ $existingPembayaran?->jenis ?? '' }}'
    }"
>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- SUCCESS FLASH --}}
        @if(request('status') === 'success')
        <div class="mb-8 overflow-hidden rounded-3xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-green-50 p-6 text-center shadow-lg dark:border-emerald-800 dark:from-emerald-900/40 dark:to-green-900/40">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-800/50">
                <svg class="h-8 w-8 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-bold text-emerald-800 dark:text-emerald-200">Pembayaran Berhasil!</h3>
            <p class="mt-1 text-sm text-emerald-600 dark:text-emerald-300">Terima kasih, pembayaran Anda telah diterima dan sedang diproses.</p>
        </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-10">
            <span class="inline-block rounded-full bg-indigo-100 px-4 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">Pembayaran</span>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Pembayaran Pendaftaran</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Selesaikan pembayaran untuk melanjutkan proses pendaftaran acara.</p>
        </div>

        {{-- STATUS PEMBAYARAN CARD --}}
        @if($existingPembayaran)
        <div class="mb-8 overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-xl dark:border-slate-700/60 dark:bg-slate-800/80">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Status Pembayaran</h3>
                    <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium text-white">
                        {{ $existingPembayaran->jenis === 'midtrans' ? 'Online' : 'Manual' }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center gap-4">
                        @if($existingPembayaran->status === 'dibayar' || $existingPembayaran->status === 'lunas')
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 dark:bg-emerald-900/50">
                            <svg class="h-8 w-8 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-emerald-700 dark:text-emerald-300">LUNAS</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Pembayaran telah dikonfirmasi</p>
                        </div>
                        @elseif($existingPembayaran->status === 'menunggu')
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 dark:bg-amber-900/50">
                            <svg class="h-8 w-8 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-amber-700 dark:text-amber-300">MENUNGGU</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Pembayaran sedang diproses</p>
                        </div>
                        @elseif($existingPembayaran->status === 'belum_dibayar')
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-100 dark:bg-rose-900/50">
                            <svg class="h-8 w-8 text-rose-600 dark:text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-rose-700 dark:text-rose-300">BELUM DIBAYAR</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Silakan selesaikan pembayaran Anda</p>
                        </div>
                        @endif
                    </div>
                    <div class="ml-auto flex flex-wrap gap-3 text-sm">
                        <div class="rounded-2xl bg-slate-50 px-4 py-2 dark:bg-slate-700/50">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Metode</p>
                            <p class="font-semibold text-slate-900 dark:text-white">
                                @if($existingPembayaran->jenis === 'midtrans') Midtrans Online
                                @elseif($existingPembayaran->jenis === 'kredit') Transfer
                                @elseif($existingPembayaran->jenis === 'cash') Cash
                                @else {{ ucfirst($existingPembayaran->jenis) }} @endif
                            </p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-2 dark:bg-slate-700/50">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $existingPembayaran->created_at ? $existingPembayaran->created_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- CONTENT --}}
        @if($pendaftarans)
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- DETAIL PENDAFTARAN --}}
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Detail Pendaftaran</h2>
                    <span class="badge-info">Aktif</span>
                </div>
                <div class="mt-6 space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-100 pb-3 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Nama Pendaftar</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $pendaftarans?->users?->name ?? $pendaftarans?->nama_pendaftar ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Nama Acara</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $pendaftarans?->acaras?->name_acara ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Status Pendaftaran</span>
                        <span class="badge-warning">{{ ucfirst(str_replace('_', ' ', $pendaftarans?->status ?? 'menunggu')) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Berkas Pendaftaran</span>
                        @if ($pendaftarans?->file)
                            <a href="{{ Storage::url($pendaftarans?->file) }}" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-700">Lihat File</a>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </div>
                    @if($existingPembayaran?->bukti_pembayaran)
                    <div class="flex justify-between border-b border-slate-100 pb-3 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Bukti Pembayaran</span>
                        <a href="{{ Storage::url($existingPembayaran->bukti_pembayaran) }}" target="_blank" class="font-medium text-emerald-600 hover:text-emerald-700">Lihat Bukti</a>
                    </div>
                    @endif
                    <div class="flex justify-between pt-2">
                        <span class="text-slate-500 dark:text-slate-400">Total Pembayaran</span>
                        <span class="text-xl font-bold text-emerald-600">
                            @php $biayaAcara = $pendaftarans?->acaras?->biaya; @endphp
                            {{ $biayaAcara ? 'Rp ' . number_format($biayaAcara->nominal ?? 0, 0, ',', '.') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- INSTRUKSI & FORM PEMBAYARAN --}}
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                    @if($existingPembayaran && ($existingPembayaran->status === 'dibayar' || $existingPembayaran->status === 'lunas'))
                        Detail Pembayaran
                    @else
                        Instruksi Pembayaran
                    @endif
                </h2>
                <div class="mt-6 space-y-5 text-sm text-slate-600 dark:text-slate-300">

                    {{-- PAYMENT CODE --}}
                    @if($paymentCode)
                    <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 p-5 dark:from-emerald-950/40 dark:to-teal-950/40 border border-emerald-100 dark:border-emerald-800/50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/50">
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">Kode Pembayaran</h3>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center justify-between rounded-xl bg-white/70 px-4 py-3 dark:bg-slate-800/70">
                                <span class="text-slate-500 dark:text-slate-400">Order ID</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-sm font-bold text-emerald-700 dark:text-emerald-300">{{ $paymentCode }}</span>
                                    <button type="button" onclick="copyText(this, '{{ $paymentCode }}')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-emerald-600 dark:hover:bg-slate-700" title="Salin kode pembayaran">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Gunakan kode ini sebagai referensi pembayaran Anda.</p>
                    </div>
                    @endif

                    {{-- QR CODE --}}
                    @if($paymentCode)
                    <div class="rounded-2xl bg-white p-5 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700">
                                <svg class="h-5 w-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">Scan QR Code</h3>
                        </div>
                        @php
                            $qrData = 'PEMBAYARAN HIMANIKKA\nOrder: ' . $paymentCode . '\nBank: BRI\nRek: 1234567890\nAn: HIMANIKKA';
                            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($qrData);
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="rounded-2xl border-2 border-dashed border-slate-200 p-4 dark:border-slate-700">
                                <img src="{{ $qrUrl }}"
                                     alt="QR Code Pembayaran"
                                     class="h-48 w-48 object-contain"
                                     loading="lazy"
                                     onerror="this.parentElement.innerHTML='<p class=\'text-sm text-rose-500\'>Gagal memuat QR Code</p>'"
                                >
                            </div>
                            <p class="mt-3 text-xs text-center text-slate-500 dark:text-slate-400">
                                Scan QR code di atas untuk melakukan pembayaran melalui mobile banking
                            </p>
                        </div>
                    </div>
                    @endif

                    {{-- REKENING BANK --}}
                    <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 p-5 dark:from-indigo-950/50 dark:to-blue-950/50 border border-indigo-100 dark:border-indigo-800/50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/50">
                                <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">Transfer Bank</h3>
                        </div>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between rounded-xl bg-white/70 px-4 py-3 dark:bg-slate-800/70">
                                <span class="text-slate-500 dark:text-slate-400">Bank</span>
                                <span class="font-semibold text-slate-900 dark:text-white">BRI</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-white/70 px-4 py-3 dark:bg-slate-800/70">
                                <span class="text-slate-500 dark:text-slate-400">No. Rekening</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-lg font-bold text-indigo-700 dark:text-indigo-300">1234567890</span>
                                    <button type="button" onclick="copyRekening(this)" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-indigo-600 dark:hover:bg-slate-700" title="Salin nomor rekening">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-white/70 px-4 py-3 dark:bg-slate-800/70">
                                <span class="text-slate-500 dark:text-slate-400">Atas Nama</span>
                                <span class="font-semibold text-slate-900 dark:text-white">HIMANIKKA</span>
                            </div>
                        </div>
                    </div>

                    {{-- INFO BAYAR --}}
                    <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-4 dark:border-indigo-800 dark:bg-indigo-950">
                        <p class="text-sm text-indigo-700 dark:text-indigo-300">
                            Jika memilih pembayaran transfer, silakan transfer ke rekening di atas lalu upload bukti pembayaran.
                            Untuk pembayaran cash, pembayaran dilakukan langsung kepada panitia.
                        </p>
                    </div>

                    {{-- MIDTRANS BUTTON --}}
                    @if($snapToken && (!$existingPembayaran || $existingPembayaran->status === 'belum_dibayar' || $existingPembayaran->status === 'menunggu'))
                    <button type="button" id="pay-snap" class="btn-primary w-full justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Bayar Online (Midtrans)
                    </button>
                    <div class="relative flex items-center py-2">
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                        <span class="mx-4 flex-shrink text-xs text-slate-400">atau bayar manual</span>
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    @endif

                    {{-- TOMBOL BAYAR MANUAL --}}
                    @if(!$existingPembayaran || $existingPembayaran->status === 'belum_dibayar')
                    <button type="button" @click="pembayaranOpen = true" class="btn-secondary w-full justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Bayar Manual (Upload Bukti)
                    </button>
                    @elseif($existingPembayaran && $existingPembayaran->status !== 'dibayar' && $existingPembayaran->status !== 'lunas')
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-center text-sm text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-300">
                        Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi dari panitia.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        {{-- EMPTY STATE --}}
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white/70 p-12 text-center dark:border-slate-700 dark:bg-slate-900/70">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-black text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">!</div>
            <h2 class="mt-4 text-2xl font-bold text-slate-900 dark:text-white">Belum Ada Pendaftaran</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Anda belum mendaftar di acara manapun. Silakan daftar terlebih dahulu.</p>
            <a href="{{ route('pendaftaran.index') }}" class="btn-primary mt-6 inline-flex">Daftar Sekarang</a>
        </div>
        @endif

        {{-- MODAL PEMBAYARAN --}}
        @if($pendaftarans)
        <div x-show="pembayaranOpen" x-cloak x-transition class="modal-backdrop">
            <div @click.away="pembayaranOpen = false" class="modal-container max-w-lg">
                <div class="modal-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Konfirmasi Pembayaran</h3>
                            <p class="mt-1 text-sm text-slate-500">Lengkapi data pembayaran di bawah ini.</p>
                        </div>
                        <button type="button" @click="pembayaranOpen = false" class="btn-icon">✕</button>
                    </div>
                </div>

                <form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" class="modal-body space-y-4" x-data="{ jenis: '' }">
                    @csrf
                    <input type="hidden" name="pendaftaran_id" value="{{ $pendaftarans?->id }}">
                    <input type="hidden" name="status" value="menunggu">

                    <div class="space-y-3 rounded-2xl bg-slate-50 p-4 dark:bg-slate-900">
                        <div class="flex justify-between border-b border-slate-200 pb-2 dark:border-slate-700">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</span>
                            <span class="text-sm text-slate-900 dark:text-white">{{ $pendaftarans?->users?->name ?? $pendaftarans?->nama_pendaftar ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-2 dark:border-slate-700">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Acara</span>
                            <span class="text-sm text-slate-900 dark:text-white">{{ $pendaftarans?->acaras?->name_acara ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Total</span>
                            <span class="text-lg font-bold text-emerald-600">
                                @php $biayaAcara = $pendaftarans?->acaras?->biaya; @endphp
                                {{ $biayaAcara ? 'Rp ' . number_format($biayaAcara->nominal ?? 0, 0, ',', '.') : '-' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Jenis Pembayaran</label>
                        <select name="jenis" x-model="jenis" required class="form-input">
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="kredit">Transfer (Upload Bukti)</option>
                            <option value="cash">Cash (Bayar Langsung)</option>
                        </select>
                        @error('jenis')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- REKENING INFO --}}
                    <div x-show="jenis == 'kredit'" x-transition>
                        <div class="rounded-2xl border border-indigo-200 bg-gradient-to-br from-indigo-50 to-blue-50 p-4 dark:border-indigo-800 dark:from-indigo-950/50 dark:to-blue-950/50">
                            <h4 class="mb-3 text-sm font-semibold text-indigo-700 dark:text-indigo-300">Transfer ke rekening berikut:</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between rounded-lg bg-white/80 px-3 py-2 dark:bg-slate-800/80">
                                    <span class="text-slate-500">Bank</span>
                                    <span class="font-semibold text-slate-900 dark:text-white">BRI</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-white/80 px-3 py-2 dark:bg-slate-800/80">
                                    <span class="text-slate-500">No. Rekening</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-indigo-600 dark:text-indigo-300">1234567890</span>
                                        <button type="button" onclick="copyRekening(this)" class="rounded p-1 text-slate-400 hover:text-indigo-600" title="Salin">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-between rounded-lg bg-white/80 px-3 py-2 dark:bg-slate-800/80">
                                    <span class="text-slate-500">Atas Nama</span>
                                    <span class="font-semibold text-slate-900 dark:text-white">HIMANIKKA</span>
                                </div>
                            </div>
                        </div>
                        <label class="form-label mt-3">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf"
                            class="form-input file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-200 dark:file:bg-slate-700 dark:file:text-white">
                        <p class="form-help">Format JPG, PNG, PDF maksimal 2MB</p>
                        @error('bukti_pembayaran')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- INFO CASH --}}
                    <div x-show="jenis == 'cash'" x-transition class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700 dark:border-amber-800 dark:bg-amber-950 dark:text-amber-300">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Pembayaran Cash</p>
                                <p class="mt-1">Pembayaran dilakukan langsung kepada panitia HIMANIKKA. Status pembayaran akan menjadi <span class="font-bold">"Belum Dibayar"</span> hingga panitia mengonfirmasi pembayaran Anda.</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-4 -mx-5 -mb-4 px-5 py-4">
                        <button type="button" @click="pembayaranOpen = false" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
function copyRekening(el) {
    var text = '1234567890';
    navigator.clipboard.writeText(text).then(function() {
        el.classList.add('text-emerald-500');
        setTimeout(function() {
            el.classList.remove('text-emerald-500');
        }, 2000);
    });
}
function copyText(el, text) {
    navigator.clipboard.writeText(text).then(function() {
        el.classList.add('text-emerald-500');
        setTimeout(function() {
            el.classList.remove('text-emerald-500');
        }, 2000);
    });
}
</script>
@endpush
@endsection
