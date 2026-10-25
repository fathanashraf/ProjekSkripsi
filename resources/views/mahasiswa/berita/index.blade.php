@extends('Mahasiswa.layouts.app')

@section('title', 'berita HIMANIKKA')

@section('content')
<main class="min-h-screen bg-gradient-to-b from-slate-50 to-white text-slate-900 dark:from-slate-950 dark:to-slate-900 dark:text-white">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
            <div class="absolute -left-20 top-40 h-80 w-80 rounded-full bg-teal-500/20 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">
            <div class="max-w-3xl">
                <span class="mb-6 inline-flex items-center rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300">
                    Agenda & Kegiatan
                </span>

                <h1 class="text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                    Berita
                    <span class="bg-gradient-to-r from-indigo-600 to-teal-500 bg-clip-text text-transparent">HIMANIKKA</span>
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-300">
                    Lihat Berita Terbaru Seputar HIMANIKKA.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16">
        <div
            x-data="{
                detailOpen: false,
                daftarOpen: false,
                commentOpen: false,
                shareOpen: false,
                likeOpen: false,
                dislikeOpen: false,
                selected: null,
                daftarSelected: null
            }"
            @keydown.escape.window="detailOpen = false; daftarOpen = false; commentOpen = false; shareOpen = false; likeOpen = false"
        >
            @if(isset($beritas) && $beritas->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($beritas as $berita)
                        <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-900">
                            <div
                                class="cursor-pointer"
                                @click="detailOpen = true; selected = {
                                    id: {{ $berita->id }},
                                    name_berita: '{{ $berita->name_berita }}',
                                    keterangan: '{{ $berita->keterangan }}',
                                    thumnail: '{{ $berita->thumnail }}',
                                    user: '{{ optional($berita->user)->name ?? '-' }}',
                                }"
                            >
                                <div class="relative flex h-72 items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-500/10 to-teal-500/10">
                                    @foreach ($beritas as $berita)
                                        @if($berita->thumnail)
                                        <img
                                            src="{{ asset('storage/' . $berita->thumnail) }}"
                                            alt="{{ $berita->name_berita ?? 'berita' }}"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-teal-500 text-4xl font-black text-white shadow-xl">
                                                A
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                        {{ $berita->name_berita ?? 'name_berita berita belum tersedia' }}
                                    </h3>

                                    <p class="mt-2 line-clamp-2 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $berita->keterangan ?? 'keterangan belum tersedia.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3 px-6 pb-6">
                                <button
                                    type="button"
                                    class="inline-flex flex-1 items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                                    @click="detailOpen = true; selected = {
                                        id: {{ $berita->id }},
                                    name_berita: '{{ $berita->name_berita }}',
                                    keterangan: '{{ $berita->keterangan }}',
                                    thumnail: '{{ $berita->thumnail }}',
                                    user: '{{ optional($berita->user)->name ?? '-' }}',
                                    }"
                                >
                                    Detail
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white/70 p-12 text-center dark:border-slate-700 dark:bg-slate-900/70">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-black text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300">
                        !
                    </div>
                    <h2 class="mt-4 text-2xl font-bold">berita belum tersedia</h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Data berita belum diinput ke dalam sistem.
                    </p>
                </div>
            @endif

            <div x-cloak x-show="detailOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900" @click.away="detailOpen = false">
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="selected?.name_berita"></h3>
                            <p class="text-sm text-slate-900 dark:text-white" x-text="selected?.keterangan"></p>
                        </div>
                        <button type="button" @click="detailOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <div class="p-6">
                        <div class="relative flex h-72 items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-500/10 to-teal-500/10">
                            @foreach ($beritas as $berita)
                                @if($berita->thumnail)
                                        <img
                                            src="{{ asset('storage/' . $berita->thumnail) }}"
                                            alt="{{ $berita->name_berita ?? 'berita' }}"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-teal-500 text-4xl font-black text-white shadow-xl">
                                                A
                                            </div>
                                        </div>
                                    @endif
                            @endforeach        
                            
                                </div>

                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="likeOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.217 25.18 25.18 0 01-4.207-3.06C4.99 15.09 3 12.11 3 8.75 3 5.307 5.784 2.5 9.25 2.5c1.74 0 3.31.82 4.25 2.1.94-1.28 2.51-2.1 4.25-2.1C21.216 2.5 24 5.307 24 8.75c0 3.36-1.99 6.34-4.026 8.868a25.18 25.18 0 01-4.207 3.06 15.247 15.247 0 01-.405.229l-.007.003-.002.001a1.75 1.75 0 01-1.677 0z"/>
    </svg>
    Like
</button>

<button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="commentOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path fill-rule="evenodd" d="M4.804 3.757A2.75 2.75 0 017.14 2.5h9.72a2.75 2.75 0 012.75 2.75v8.5a2.75 2.75 0 01-2.75 2.75H10.5l-4.28 3.42A.75.75 0 014.5 19.25V16.5A2.75 2.75 0 012 13.75v-7.5c0-1.07.498-2.08 1.304-2.493z" clip-rule="evenodd"/>
    </svg>
    Komentar
</button>

<button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="dislikeOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
  <path d="M7 11V3a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2-2l-1-5a2 2 0 0 0-2-2h-7a3 3 0 0 0-3 3v6z"/>
</svg>
    dislike
</button>

<button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="shareOpen = true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
        <path d="M15.75 5.25a3.75 3.75 0 11-2.94 6.08l-4.93 2.46a3.756 3.756 0 010 1.42l4.93 2.46a3.75 3.75 0 11-.67 1.34l-4.93-2.46a3.75 3.75 0 110-5.44l4.93-2.46A3.75 3.75 0 0115.75 5.25z"/>
    </svg>
    Share
</button>
                        </div>

                        <div class="space-y-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            <p>
                                <span class="font-semibold text-slate-900 dark:text-white">Judul Berita:</span>
                                <span x-text="selected?.name_berita"></span>
                            </p>
                            <p>
                                <span class="font-semibold text-slate-900 dark:text-white">keterangan:</span>
                                <span x-text="selected?.keterangan"></span>
                            </p>
                            <p>
                                <span class="font-semibold text-slate-900 dark:text-white">Dikirim Oleh:</span>
                                <span x-text="selected?.user"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="likeOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="likeOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Like</h3>
                        <button type="button" @click="likeOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.berita.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="beritas_id" :value="selected?.id">
                        <input type="hidden" name="like" value="1">
                        <input type="hidden" name="dislike" value="">
                        <input type="hidden" name="Masukkan" value="">

                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Klik tombol di bawah untuk memberi like pada berita ini.
                        </p>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
                            Kirim Like
                        </button>
                    </form>
                </div>
            </div>

            <div x-cloak x-show="commentOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="commentOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Komentar</h3>
                        <button type="button" @click="commentOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.berita.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="beritas_id" :value="selected?.id">
                        <input type="hidden" name="Masukkan" value="">
                        <input type="hidden" name="like" value="">
                        <input type="hidden" name="dislike" value="">

                        <textarea
                            name="Masukkan"
                            rows="4"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                            placeholder="Tulis komentar kamu..."
                            required
                        ></textarea>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>

            <div x-cloak x-show="dislikeOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="dislikeOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Like</h3>
                        <button type="button" @click="dislikeOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>

                    <form method="POST" action="{{ route('Mahasiswa.berita.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="beritas_id" :value="selected?.id">
                        <input type="hidden" name="like" value="">
                        <input type="hidden" name="dislike" value="1">
                        <input type="hidden" name="Masukkan" value="">

                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Klik tombol di bawah untuk memberi dislike pada berita ini.
                        </p>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
                            Tidak sukai
                        </button>
                    </form>
                </div>
            </div>
            
            <div x-cloak x-show="shareOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900" @click.away="shareOpen = false">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Share</h3>
                        <button type="button" @click="shareOpen = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">✕</button>
                    </div>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Fitur share bisa dihubungkan ke link WhatsApp, copy link, atau sosial media.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-16">
        <div class="grid gap-5 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">Internal</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Kegiatan yang diperuntukkan bagi lingkungan HIMANIKKA atau mahasiswa internal.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">External</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Event atau agenda yang melibatkan pihak luar organisasi.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-bold">Syarat</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Informasi tambahan untuk mengikuti kegiatan atau event tertentu.
                </p>
            </div>
        </div>
    </section>
</main>
@endsection