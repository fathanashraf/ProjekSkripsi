<footer class="relative overflow-hidden border-t border-slate-200 bg-gradient-to-b from-white to-slate-50 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:from-slate-950 dark:to-slate-900 dark:text-slate-100">
    <div class="h-1 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            {{-- LOGO & DESKRIPSI --}}
            <div class="md:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    @if(!empty($profil) && !empty($profil->logo))
                        <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo {{ $profil->name_instansi ?? 'HIMANIKKA' }}" class="h-12 w-12 rounded-2xl object-cover shadow-md ring-1 ring-black/5 dark:ring-white/10">
                    @else
                        <img src="{{ asset('assets/logoHima-.png') }}" alt="Logo HIMANIKKA" class="h-12 w-12 rounded-2xl object-cover shadow-md ring-1 ring-black/5 dark:ring-white/10">
                    @endif
                    <div>
                        <p class="text-lg font-black text-slate-900 dark:text-white">{{ $profil->name_instansi ?? 'HIMANIKKA' }}</p>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $profil->singkatan ?? 'Himpunan Mahasiswa Informatika' }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    {{ $profil->visi ?? 'Himpunan Mahasiswa Teknik Informatika Universitas Pahlawan Tuanku Tambusai. Wadah pengembangan minat, bakat, dan aspirasi mahasiswa teknik informatika.' }}
                </p>
            </div>

            {{-- NAVIGASI --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Navigasi</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('welcome') }}#tentang_kami" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Tentang Kami</a></li>
                    <li><a href="{{ route('welcome') }}#struktur" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('welcome') }}#acara" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Acara & Kegiatan</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Berita</a></li>
                    <li><a href="{{ route('welcome') }}#aspirasi" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Aspirasi</a></li>
                </ul>
            </div>

            {{-- LAYANAN --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Layanan</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('pendaftaran.index') }}" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Pendaftaran</a></li>
                    <li><a href="{{ route('pembayaran.index') }}" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Pembayaran</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Berita</a></li>
                    <li><a href="{{ route('auth.login') }}" class="text-sm text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Login</a></li>
                </ul>
            </div>

            {{-- KONTAK --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Kontak</h3>
                <ul class="mt-4 space-y-3">
                    <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $profil->alamat ?? 'Universitas Pahlawan Tuanku Tambusai' }}</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>himanikka@universitas.ac.id</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>+62 xxx xxxx xxxx</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-slate-200 pt-8 dark:border-slate-800">
            <div class="flex flex-col items-center justify-between gap-4 text-center sm:flex-row">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    &copy; {{ date('Y') }} <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $profil->name_instansi ?? 'HIMANIKKA' }}</span>. All rights reserved.
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Dibangun dengan <span class="text-red-500">&hearts;</span> oleh Tim Pengurus {{ $profil->singkatan ?? 'HIMANIKKA' }}
                </p>
            </div>
        </div>
    </div>
</footer>
