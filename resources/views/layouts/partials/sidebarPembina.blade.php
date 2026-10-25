<aside
    x-cloak
    @keydown.escape.window="$store.sidebar.close()"
    class="sidebar-container"
    :class="$store.sidebar.isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    {{-- Logo Section with gradient divider --}}
    <div class="relative mb-6 flex items-center justify-between gap-2 px-4 pt-6 pb-5">
        <div class="absolute bottom-0 left-4 right-4 h-px bg-gradient-to-r from-transparent via-indigo-400/30 to-transparent"></div>

        {{-- Tutup sidebar (hanya mobile) --}}
        <button
            type="button"
            @click="$store.sidebar.close()"
            class="-ml-1 rounded-xl p-2 text-slate-500 transition hover:rotate-90 hover:bg-slate-100 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white lg:hidden"
            aria-label="Tutup sidebar"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <a href="{{ route('pembina.beranda.index') }}" class="group flex items-center gap-3">
            <div class="relative">
                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-indigo-500/30 to-purple-500/30 opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-100"></div>
                <img
                    src="{{ asset('assets/logoHima-.png') }}"
                    alt="Logo HIMANIKKA"
                    class="relative h-10 w-10 flex-shrink-0 rounded-xl shadow-md transition-all duration-300 group-hover:scale-110"
                >
            </div>
            <div>
                <span class="hidden whitespace-nowrap bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-lg font-bold text-transparent dark:from-indigo-400 dark:to-purple-400 lg:inline">
                    HIMANIKKA
                </span>
                <p class="hidden text-[10px] font-medium text-slate-400 dark:text-slate-500 lg:block">Panel Pembina</p>
            </div>
        </a>

        {{-- Spacer agar logo tetap center pada desktop --}}
        <span class="h-9 w-9 shrink-0 lg:hidden" aria-hidden="true"></span>
    </div>

    <nav class="stagger-in space-y-5 px-3 pb-6">
        {{-- Menu Utama --}}
        <section>
            <h2 class="sidebar-section-title flex items-center gap-2">
                <svg class="h-3 w-3 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z"/>
                </svg>
                Menu Utama
            </h2>
            <div class="space-y-0.5">
                <a href="{{ route('pembina.beranda.index') }}" class="sidebar-link @if(request()->routeIs('pembina.beranda.*')) sidebar-link-active @endif" data-color="blue">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>
        </section>

        {{-- Tentang HIMANIKKA --}}
        <section>
            <h2 class="sidebar-section-title flex items-center gap-2">
                <svg class="h-3 w-3 text-cyan-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.625 16.5a1.875 1.875 0 100-3.75 1.875 1.875 0 000 3.75zm0 0v2.625m0-13.5a1.875 1.875 0 100-3.75 1.875 1.875 0 000 3.75zm0 0v2.625m0-13.5v2.625m0 13.5v2.625"/>
                </svg>
                Tentang HIMANIKKA
            </h2>
            <div class="space-y-0.5">
                <a href="{{ route('pembina.tentang.index') }}" class="sidebar-link @if(request()->routeIs('pembina.tentang.*')) sidebar-link-active @endif" data-color="cyan">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tentang HIMANIKKA</span>
                </a>
                <a href="{{ route('pembina.struktur.index') }}" class="sidebar-link @if(request()->routeIs('pembina.struktur.*')) sidebar-link-active @endif" data-color="orange">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Struktur Organisasi</span>
                </a>
            </div>
        </section>

        {{-- Kegiatan & Informasi --}}
        <section>
            <h2 class="sidebar-section-title flex items-center gap-2">
                <svg class="h-3 w-3 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                </svg>
                Kegiatan & Informasi
            </h2>
            <div class="space-y-0.5">
                <a href="{{ route('pembina.acara.index') }}" class="sidebar-link @if(request()->routeIs('pembina.acara.*')) sidebar-link-active @endif" data-color="emerald">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Acara & Kegiatan</span>
                </a>
                <a href="{{ route('pembina.berita.index') }}" class="sidebar-link @if(request()->routeIs('pembina.berita.*')) sidebar-link-active @endif" data-color="purple">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V6a2 2 0 012-2h.01M9 10h.01M13 10h.01M9 14h.01M13 14h.01"/>
                    </svg>
                    <span>Berita & Pengumuman</span>
                </a>
                <a href="{{ route('pembina.aspirasi.index') }}" class="sidebar-link @if(request()->routeIs('pembina.aspirasi.*')) sidebar-link-active @endif" data-color="rose">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <span>Aspirasi & Pengaduan</span>
                </a>
            </div>
        </section>

        {{-- Arsip --}}
        <section>
            <h2 class="sidebar-section-title flex items-center gap-2">
                <svg class="h-3 w-3 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z"/>
                </svg>
                Arsip
            </h2>
            <div class="space-y-0.5">
                <a href="{{ route('pembina.laporan.index') }}" class="sidebar-link @if(request()->routeIs('pembina.laporan.*')) sidebar-link-active @endif" data-color="yellow">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('pembina.keuangan.index') }}" class="sidebar-link @if(request()->routeIs('pembina.keuangan.*')) sidebar-link-active @endif" data-color="red">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Keuangan</span>
                </a>
                <a href="{{ route('pembina.dokumentasi.index') }}" class="sidebar-link @if(request()->routeIs('pembina.dokumentasi.*')) sidebar-link-active @endif" data-color="indigo">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                    </svg>
                    <span>Dokumentasi</span>
                </a>
            </div>
        </section>

        {{-- Pengaturan --}}
        <section>
            <div class="mb-3 mt-6 border-t border-slate-200/30 dark:border-slate-800/50"></div>
            <h2 class="sidebar-section-title flex items-center gap-2">
                <svg class="h-3 w-3 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.75 5.25l-3.997.695a11.952 11.952 0 00-5.506 0l-3.997-.695A1.5 1.5 0 003 6.735v3.372a1.5 1.5 0 001.25 1.485l3.997.695c1.81.315 3.666.315 5.506 0l3.997-.695A1.5 1.5 0 0021 10.107V6.735a1.5 1.5 0 00-1.25-1.485z"/>
                </svg>
                Pengaturan
            </h2>
            <div class="space-y-1.5">
                <a href="{{ route('profile.index') }}"
                   class="sidebar-link-profile @if(request()->routeIs('profile.*')) sidebar-link-active @endif"
                   data-color="cyan">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0a4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profil Saya</span>
                </a>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit"
                            class="sidebar-link-logout"
                            title="Logout">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </section>
    </nav>
</aside>