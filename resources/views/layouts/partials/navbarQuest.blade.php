{{-- layouts/partials/navbar.blade.php --}}
<nav class="navbar sticky top-0 z-50 border-b border-white/10 bg-white/75 backdrop-blur-xl transition-all duration-500 dark:border-slate-700/50 dark:bg-slate-900/75">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 sm:px-6 lg:px-8">
        {{-- Logo --}}
        <a href="{{ route('Mahasiswa.beranda.index') }}" class="navbar-logo group flex items-center gap-3 text-lg font-black text-slate-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400">
            <img
                src="{{ asset('assets/logoHima-.png') }}"
                alt="Logo HIMANIKKA"
                class="h-10 w-10 rounded-2xl object-cover shadow-md ring-1 ring-black/5 transition duration-200 group-hover:scale-105"
            >
            <span class="hidden whitespace-nowrap lg:inline">
                HIMA<span class="font-bold text-teal-500 dark:text-teal-200">NIKKA</span>
            </span>
        </a>

        {{-- Desktop Navigation --}}
        <div class="hidden items-center gap-1 lg:flex">
            <a href="{{route('welcome')}}" class="navbar-link rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100/70 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400">
                Home
            </a>

            <div x-data="{ open: false }" class="relative">
                <button type="button" @mouseenter="open = true" @mouseleave="open = false" class="navbar-link rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100/70 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400">
                    Tentang Kami
                </button>

                <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-transition.origin.top.left x-cloak class="absolute left-0 top-full mt-2 w-56 rounded-2xl border border-white/10 bg-white/90 p-2 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/90">
                    <a href="#tentang_kami" class="block rounded-xl px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/60">Tentang HIMANIKKA</a>
                    <a href="#struktur" class="block rounded-xl px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/60">Struktur HIMANIKKA</a>
                </div>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button type="button" @mouseenter="open = true" @mouseleave="open = false" class="navbar-link rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100/70 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400">
                    Informasi
                </button>

                <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-transition.origin.top.left x-cloak class="absolute left-0 top-full mt-2 w-56 rounded-2xl border border-white/10 bg-white/90 p-2 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/90">
                    <a href="#acara" class="block rounded-xl px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/60">Acara</a>
                    <a href="#berita" class="block rounded-xl px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/60">Berita</a>
                </div>
            </div>
        </div>

        {{-- Right Section --}}
        <div class="flex items-center gap-2">
            {{-- Notifications --}}
            @php $notifRoles = ['admin', 'pembina']; $showNotif = auth()->check() && auth()->user()->role && in_array(auth()->user()->role->name, $notifRoles, true); @endphp
            @if($showNotif)
            <div x-data="notificationComponent({ endpoint: @js(route('admin.notifications.index')) })" @click.outside="notificationsOpen = false" @keydown.escape.window="notificationsOpen = false" class="relative">
                <button @click="toggleNotifications()" class="navbar-icon relative rounded-xl p-2 text-slate-700 transition hover:scale-110 hover:bg-slate-100/70 hover:shadow-sm dark:text-slate-300 dark:hover:bg-slate-800/50" :class="notificationsOpen ? 'bg-slate-100/80 shadow-sm dark:bg-slate-800/60' : ''" aria-label="Notifikasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>

                    <span x-show="unreadCount > 0" x-cloak class="absolute inset-0 -z-10 rounded-xl bg-indigo-400/20 blur-md" style="animation: notifDotPing 2.4s ease-out infinite"></span>

                    <span x-show="unreadCount > 0" x-cloak
                          x-transition:enter="transition ease-out duration-200"
                          x-transition:enter-start="scale-50 opacity-0"
                          x-transition:enter-end="scale-100 opacity-100"
                          class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-bold text-white shadow-lg dark:border-slate-900">
                        <span x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
                    </span>
                </button>

                <div x-show="notificationsOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="notif-panel absolute right-0 top-full z-50 mt-2 w-80 max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-white/10 bg-white/95 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/95 sm:w-96">
                    <div class="flex items-center justify-between gap-2 border-b border-slate-200/50 bg-gradient-to-r from-indigo-50/70 to-purple-50/50 px-5 py-3 dark:border-slate-700/50 dark:from-indigo-950/40 dark:to-purple-950/30">
                        <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-md shadow-indigo-500/25">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </span>
                            <div>
                                <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Notifikasi</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400"><span x-text="unreadCount"></span> belum dibaca</p>
                            </div>
                        </div>
                        <button x-on:click="markAllRead()" x-show="unreadCount > 0" x-cloak
                                class="shrink-0 rounded-lg bg-white/80 px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm ring-1 ring-slate-200/70 transition hover:bg-white hover:text-indigo-600 hover:shadow dark:bg-slate-700/50 dark:text-slate-300 dark:ring-slate-600/50 dark:hover:text-indigo-300">
                            Tandai Semua
                        </button>
                    </div>

                    <div class="custom-scrollbar max-h-80 overflow-y-auto overscroll-contain">
                        <div x-show="loading && notifications.length === 0" class="space-y-3 px-5 py-4">
                            <template x-for="i in 3" :key="i">
                                <div class="flex items-start gap-3">
                                    <div class="skeleton h-9 w-9 shrink-0"></div>
                                    <div class="flex-1 space-y-2 py-1">
                                        <div class="skeleton h-3 w-3/4"></div>
                                        <div class="skeleton h-3 w-full"></div>
                                        <div class="skeleton h-3 w-1/3"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div x-show="!loading && notifications.length === 0" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                            <span class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700/50">
                                <svg class="h-7 w-7 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </span>
                            <p class="text-sm font-medium">Tidak ada notifikasi</p>
                            <p class="mt-1 text-xs opacity-70">Semua sudah beres. Kerja bagus!</p>
                        </div>

                        <template x-for="notification in notifications" :key="notification.id">
                            <div @click="markRead(notification.id)"
                                 class="notif-item group relative cursor-pointer border-b border-slate-100 px-5 py-3 transition last:border-b-0 hover:bg-slate-50 dark:border-slate-700/50 dark:hover:bg-slate-700/40"
                                 :class="notification.read_at ? 'bg-white/60 dark:bg-slate-800/40' : 'bg-indigo-50/60 dark:bg-slate-700/30'">
                                <span x-show="!notification.read_at" class="notif-dot-pulse absolute left-4 top-4 h-2 w-2 rounded-full bg-indigo-500"></span>
                                <div class="flex items-start gap-3 pl-3">
                                    <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl shadow-md transition-transform duration-200 group-hover:scale-110"
                                         :class="'bg-gradient-to-br ' + notificationColor(notification.data?.type)">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="notificationIcon(notification.data?.type)"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 py-1">
                                        <p class="line-clamp-1 text-sm font-medium text-slate-900 dark:text-white" x-text="notification.data?.title || 'Notifikasi baru'"></p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-500 dark:text-slate-400" x-text="notification.data?.message || 'Ada pembaruan baru'"></p>
                                        <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500"
                                           x-text="new Date(notification.created_at).toLocaleDateString('id-ID', { year:'numeric', month:'short', day:'numeric', hour:'2-digit', minute:'2-digit' })"></p>
                                    </div>
                                    <svg class="mt-2 h-4 w-4 shrink-0 text-slate-300 transition-all duration-200 group-hover:translate-x-1 group-hover:text-indigo-500 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            @endif

            {{-- Dark Mode --}}
            <button @click="toggleDarkMode()" class="navbar-icon rounded-xl p-2 text-slate-700 transition hover:bg-slate-100/70 dark:text-slate-300 dark:hover:bg-slate-800/50">
                <svg x-show="!darkMode" x-cloak x-transition.scale.75 class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg x-show="darkMode" x-cloak x-transition.scale.75 class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            {{-- Auth Dropdown --}}
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="navbar-auth flex items-center gap-2 rounded-xl px-2 py-1.5 text-slate-700 transition hover:bg-slate-100/70 dark:text-slate-300 dark:hover:bg-slate-800/50">
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
                            alt="Profile"
                            class="h-9 w-9 rounded-full object-cover ring-2 ring-white/60 dark:ring-slate-700/60"
                        >
                        <div class="hidden flex-col text-left text-sm sm:flex dark:text-slate-300">
                            <span class="font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email ?? 'admin@himanikka.id' }}</span>
                        </div>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition.origin.top.right x-cloak @click.outside="open = false" class="absolute right-0 z-50 mt-2 w-60 overflow-hidden rounded-2xl border border-white/10 bg-white/90 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-900/90">
                        <div class="border-b border-slate-200/60 px-4 py-4 dark:border-slate-700/50">
                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
                                    alt="Avatar"
                                    class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-200 dark:ring-slate-700"
                                >
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                            Profil Saya
                        </a>

                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                            Dashboard
                        </a>

                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="hidden items-center gap-2 sm:flex">
                    <a href="{{ route('auth.login') }}" class="navbar-btn rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-2 text-xs font-semibold text-white shadow-lg transition hover:from-indigo-600 hover:to-purple-700">
                        Login
                    </a>
                    <a href="{{ route('auth.register') }}" class="navbar-btn rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-2 text-xs font-semibold text-white shadow-lg transition hover:from-indigo-600 hover:to-purple-700">
                        Daftar
                    </a>
                </div>
            @endauth

            {{-- Mobile Menu --}}
            <button @click="$store.mobileNav.toggle()" class="navbar-icon rounded-xl p-2 text-slate-700 transition hover:bg-slate-100/70 lg:hidden dark:text-slate-300 dark:hover:bg-slate-800/50" aria-label="Toggle menu">
                <svg x-show="!$store.mobileNav.isOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="$store.mobileNav.isOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div
        x-show="$store.mobileNav.isOpen"
        x-cloak
        x-transition.opacity
        @click="$store.mobileNav.close()"
        class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
    ></div>

    <aside
        x-show="$store.mobileNav.isOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full opacity-60"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-60"
        @keydown.escape.window="$store.mobileNav.close()"
        class="fixed right-0 top-0 z-50 h-dvh w-80 max-w-[85vw] overflow-y-auto overscroll-contain border-l border-slate-200/60 bg-white/95 p-4 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-900/95 lg:hidden"
    >
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3 dark:border-slate-700/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/logoHima-.png') }}" alt="Logo" class="h-10 w-10 rounded-2xl object-cover">
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">HIMANIKKA</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Himpunan Mahasiswa Informatika</p>
                </div>
            </div>

            <button @click="$store.mobileNav.close()" class="rounded-xl p-2 text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60" aria-label="Close menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="stagger-in mt-4 space-y-1">
            <a href="{{ route('Mahasiswa.beranda.index') }}" @click="$store.mobileNav.close()" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">Home</a>

            <button @click="$store.mobileNav.toggleAbout()" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tentang Kami</span>
                </div>
                <svg class="h-4 w-4 transition-transform" :class="$store.mobileNav.aboutOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="$store.mobileNav.aboutOpen" x-transition class="ml-3 space-y-1 border-l border-sky-200 pl-3 dark:border-sky-800">
                <a href="{{ route('Mahasiswa.tentang.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Tentang HIMANIKKA
                </a>
                <a href="{{ route('Mahasiswa.struktur.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Struktur HIMANIKKA
                </a>
            </div>

            <button @click="$store.mobileNav.toggleInfo()" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Informasi</span>
                </div>
                <svg class="h-4 w-4 transition-transform" :class="$store.mobileNav.infoOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="$store.mobileNav.infoOpen" x-transition class="ml-3 space-y-1 border-l border-indigo-200 pl-3 dark:border-indigo-800">
                <a href="{{ route('Mahasiswa.acara.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Acara
                </a>
                <a href="{{ route('Mahasiswa.berita.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Berita
                </a>
            </div>

            {{-- Dokumentasi --}}
            <button @click="$store.mobileNav.toggleDocs()" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Dokumentasi</span>
                </div>
                <svg class="h-4 w-4 transition-transform" :class="$store.mobileNav.docsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="$store.mobileNav.docsOpen" x-transition class="ml-3 space-y-1 border-l border-amber-200 pl-3 dark:border-amber-800">
                <a href="{{ route('Mahasiswa.dokumentasi.acara.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    </svg>
                    Dokumentasi Acara
                </a>
                <a href="{{ route('Mahasiswa.dokumentasi.berita.index') }}" @click="$store.mobileNav.close()" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/60">
                    <svg class="h-3.5 w-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Dokumentasi Berita
                </a>
            </div>
        </div>

        @auth
            <div class="mt-4 rounded-2xl border border-slate-200/60 bg-slate-50/70 p-4 dark:border-slate-700/50 dark:bg-slate-800/60">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}" alt="Profile" class="h-10 w-10 rounded-full object-cover ring-2 ring-white/60 dark:ring-slate-700/60">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email ?? 'admin@himanikka.id' }}</p>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.index') }}" @click="$store.mobileNav.close()" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">Profil Saya</a>
                    <a href="{{ route('admin.dashboard') }}" @click="$store.mobileNav.close()" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/60">Dashboard</a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-xl px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mt-4 flex gap-2">
                <a href="{{ route('auth.login') }}" class="flex-1 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-2 text-center text-xs font-semibold text-white shadow-lg">Login</a>
                <a href="{{ route('auth.register') }}" class="flex-1 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-2 text-center text-xs font-semibold text-white shadow-lg">Daftar</a>
            </div>
        @endauth
    </aside>
</nav>