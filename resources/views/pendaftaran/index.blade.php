@extends('layouts.app')

@section('title', 'Pendaftaran Acara HIMANIKKA')

@push('scripts')
<script>window.acaraData = @json($acaras->keyBy('id'));</script>
@endpush

@section('content')
<section class="bg-slate-50 py-16 dark:bg-slate-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight text-slate-900 dark:text-white">
                Pendaftaran Acara
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-teal-500">
                    HIMANIKKA
                </span>
            </h1>
            <p class="mt-6 max-w-2xl text-base sm:text-lg leading-relaxed text-slate-600 dark:text-slate-300">
                Lengkapi formulir pendaftaran untuk mengikuti kegiatan HIMANIKKA.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">
            <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="nama_pendaftar" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Nama Pendaftar
                        </label>
                        <input
                            type="text"
                            id="nama_pendaftar"
                            name="nama_pendaftar"
                            value="{{ old('nama_pendaftar') }}"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label for="NO_HP" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            No HP
                        </label>
                        <input
                            type="text"
                            id="NO_HP"
                            name="NO_HP"
                            value="{{ old('NO_HP') }}"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="acaras_id" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Pilih Acara
                        </label>
                        <select
                            id="acaras_id"
                            name="acaras_id"
                            required
                            x-data
                            @change="
                                const acara = window.acaraData;
                                const selected = acara[$event.target.value];
                                if (selected) {
                                    $el.closest('form').querySelector('[name=biaya_pendaftaran]').value = selected.biaya ? 'Rp ' + Number(selected.biaya.nominal).toLocaleString('id-ID') : '-';
                                    const syaratEl = document.getElementById('syarat-display');
                                    if (syaratEl) {
                                        syaratEl.textContent = selected.syarat ? selected.syarat.kebutuhan : 'Tidak ada syarat acara';
                                    }
                                }
                            "
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                        >
                            <option value="">-- Pilih Acara --</option>
                            @foreach ($acaras as $acara)
                                <option value="{{ $acara->id }}">{{ $acara->name_acara }}</option>
                            @endforeach
                        </select>
                        @error('acaras_id')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Syarat Acara -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                        <h3 class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Syarat Acara
                        </h3>
                        <p id="syarat-display" class="text-sm text-slate-600 dark:text-slate-300">
                            Pilih acara untuk melihat syarat
                        </p>
                    </div>

                    <div>
                        <label for="file" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Syarat Pendaftaran (File)
                        </label>
                        <input
                            type="file"
                            id="file"
                            name="file"
                            accept=".jpg,.jpeg,.png,.pdf"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:file:bg-slate-700 dark:file:text-white"
                        >
                        @error('file')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Status Pendaftaran
                        </label>
                        <input
                            type="text"
                            name="status"
                            value="diajukan"
                            readonly
                            class="w-full rounded-lg border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-700 dark:text-slate-200"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Biaya Pendaftaran Acara
                        </label>
                        <input
                            type="text"
                            name="biaya_pendaftaran"
                            value="Pilih acara terlebih dahulu"
                            readonly
                            class="w-full rounded-lg border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-700 dark:text-slate-200"
                        >
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
                    >
                        Lanjut Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection