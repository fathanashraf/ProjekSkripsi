@extends('Mahasiswa.layouts.app')

@section('title', 'Dokumentasi Acara HIMANIKKA')

@section('content')
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-10">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Dokumentasi Acara HIMANIKKA
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Kumpulan dokumentasi kegiatan HIMANIKKA yang dapat dilihat dan diunduh langsung.
                </p>
            </div>

            <!-- Grid Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse ($acaras as $acara)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">

                        <!-- Thumbnail -->
                        <div class="relative">
                            <img src="{{ $acara->thumnail ? asset('storage/' . $acara->thumnail) : 'https://placehold.co/600x400' }}"
                                class="w-full h-56 object-cover"
                                alt="{{ $acara->name_acara }}">

                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow">
                                    {{ ucfirst($acara->tipe) }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('d F Y') }}
                                </span>

                                <span class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ count($acara->dokumentasis ?? []) }} Dokumentasi
                                </span>
                            </div>

                            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                                {{ $acara->name_acara }}
                            </h2>

                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-3 line-clamp-3">
                                {{ $acara->keterangan }}
                            </p>

                            <!-- Button -->
                            <div class="mt-6">
                                <button
                                    onclick="openModal('modal{{ $acara->id }}')"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition">
                                    Lihat Dokumentasi
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="modal{{ $acara->id }}"
                        class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm overflow-y-auto">

                        <div class="min-h-screen flex items-center justify-center p-4">

                            <div
                                class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-6xl relative shadow-2xl">

                                <!-- Header Modal -->
                                <div
                                    class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 px-6 py-4">

                                    <div>
                                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                                            {{ $acara->name_acara }}
                                        </h2>

                                        <p class="text-slate-500 text-sm mt-1">
                                            {{ $acara->keterangan }}
                                        </p>
                                    </div>

                                    <button
                                        onclick="closeModal('modal{{ $acara->id }}')"
                                        class="text-slate-500 hover:text-red-500 text-3xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Body Modal -->
                                <div class="p-6 max-h-[80vh] overflow-y-auto">

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                        @forelse ($acara->dokumentasis as $dokumentasi)
                                            <div
                                                class="bg-slate-100 dark:bg-slate-700 rounded-2xl overflow-hidden shadow">

                                                <!-- Image -->
                                                <img src="{{ asset('storage/' . $dokumentasi->file) }}"
                                                    class="w-full h-60 object-cover">

                                                <!-- Footer -->
                                                <div class="p-4">

                                                    <div class="flex gap-2">

                                                        <!-- View -->
                                                        <a href="{{ asset('storage/' . $dokumentasi->file) }}"
                                                            target="_blank"
                                                            class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm">
                                                            Lihat
                                                        </a>

                                                        <!-- Download -->
                                                        <a href="{{ asset('storage/' . $dokumentasi->file) }}"
                                                            download
                                                            class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm">
                                                            Download
                                                        </a>

                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-span-3 text-center py-16">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-16 h-16 mx-auto text-slate-400"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M3 7l9 6 9-6M4 19h16a1 1 0 001-1V6a1 1 0 00-1-1H4a1 1 0 00-1 1v12a1 1 0 001 1z" />
                                                </svg>

                                                <h3
                                                    class="text-lg font-semibold text-slate-700 dark:text-white mt-4">
                                                    Dokumentasi Belum Tersedia
                                                </h3>

                                                <p class="text-slate-500 mt-2">
                                                    Belum ada dokumentasi yang diupload untuk acara ini.
                                                </p>

                                            </div>
                                        @endforelse

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20">

                        <h2 class="text-2xl font-bold text-slate-700 dark:text-white">
                            Belum Ada Acara
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Data acara HIMANIKKA belum tersedia.
                        </p>

                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
@endsection