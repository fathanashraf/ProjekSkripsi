<header class="app-header">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-xl p-2 text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden"
                @click="$store.sidebar.toggle()"
                aria-label="Toggle sidebar"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="min-w-0 leading-tight">
                <h1 class="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">
                    @yield('title', 'Dashboard')
                </h1>
                <p class="header-subtitle hidden sm:block">Sistem Admin HIMANIKKA</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
        <div x-data="notificationComponent({ endpoint: @js(route('admin.notifications.index')) })" class="relative" @click.outside="notificationsOpen = false" @keydown.escape.window="notificationsOpen = false">
    <button
        type="button"
        @click="toggleNotifications()"
        class="relative rounded-xl p-2 text-slate-700 transition hover:scale-110 hover:bg-slate-100 hover:shadow-md dark:text-slate-300 dark:hover:bg-slate-800/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
        :class="notificationsOpen ? 'bg-slate-100 shadow-md dark:bg-slate-800/60' : ''"
        aria-label="Notifikasi"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
            />
        </svg>

        {{-- Efek getar lonceng saat ada notifikasi baru --}}
        <span
            x-show="unreadCount > 0"
            x-cloak
            class="absolute inset-0 -z-10 rounded-xl bg-indigo-400/20 blur-md"
            style="animation: notifDotPing 2.4s ease-out infinite"
        ></span>

        <span
            x-show="unreadCount > 0"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="scale-50 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            class="absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-bold text-white shadow-lg dark:border-slate-900"
        >
            <span x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
        </span>
    </button>

    <div
        x-show="notificationsOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="notif-panel absolute right-0 top-full z-50 mt-2 w-80 max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200/50 bg-white/95 shadow-2xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/95 sm:w-96"
    >
        <div class="flex items-center justify-between gap-2 border-b border-slate-200/50 bg-gradient-to-r from-indigo-50/70 to-purple-50/50 px-5 py-3 dark:border-slate-700/50 dark:from-indigo-950/40 dark:to-purple-950/30">
            <div class="flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-md shadow-indigo-500/25">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </span>
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Notifikasi</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                        <span x-text="unreadCount"></span> belum dibaca
                    </p>
                </div>
            </div>
            <button
                type="button"
                x-on:click="markAllRead()"
                x-show="unreadCount > 0"
                x-cloak
                class="shrink-0 rounded-lg bg-white/80 px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm ring-1 ring-slate-200/70 transition hover:bg-white hover:text-indigo-600 hover:shadow dark:bg-slate-700/50 dark:text-slate-300 dark:ring-slate-600/50 dark:hover:text-indigo-300"
            >
                Tandai Semua
            </button>
        </div>

        <div class="custom-scrollbar max-h-80 overflow-y-auto overscroll-contain">
            {{-- Loading skeleton --}}
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
                <div
                    @click="openDetail(notification)"
                    class="notif-item group relative cursor-pointer border-b border-slate-100/50 px-5 py-3 transition hover:bg-slate-50/70 last:border-b-0 dark:border-slate-700/50 dark:hover:bg-slate-700/40"
                    :class="notification.read_at ? 'bg-white/70 dark:bg-slate-800/50' : 'bg-gradient-to-r from-indigo-50/60 to-blue-50/40 dark:from-slate-700/30 dark:to-slate-600/20'"
                >
                    <span x-show="!notification.read_at" class="notif-dot-pulse absolute left-4 top-4 h-2 w-2 rounded-full bg-indigo-500"></span>

                    <div class="flex items-start gap-3 pl-5">
                        <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl shadow-md transition-transform duration-200 group-hover:scale-110"
                             :class="'bg-gradient-to-br ' + notificationColor(notification.data?.type)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="notificationIcon(notification.data?.type)"/>
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1 py-1">
                            <p class="line-clamp-1 text-sm font-medium text-slate-900 dark:text-white" x-text="notification.data?.title || 'Notifikasi baru'"></p>
                            <p class="mt-0.5 line-clamp-2 text-xs text-slate-500 dark:text-slate-400" x-text="notification.data?.message || 'Ada pembaruan baru'"></p>
                            <p
                                class="mt-1 text-[11px] text-slate-400 dark:text-slate-500"
                                x-text="new Date(notification.created_at).toLocaleDateString('id-ID', { year:'numeric', month:'short', day:'numeric', hour:'2-digit', minute:'2-digit' })"
                            ></p>
                        </div>

                        <svg class="mt-2 h-4 w-4 shrink-0 text-slate-300 transition-all duration-200 group-hover:translate-x-1 group-hover:text-indigo-500 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </template>
        </div>

        <div class="border-t border-slate-200/50 bg-slate-50/50 px-5 py-2.5 dark:border-slate-700/50 dark:bg-slate-900/30">
            <button
                type="button"
                @click="notificationsOpen = false"
                class="w-full rounded-xl py-1.5 text-center text-xs font-medium text-indigo-600 transition hover:bg-indigo-50 hover:text-indigo-700 dark:text-indigo-400 dark:hover:bg-indigo-950/40 dark:hover:text-indigo-300"
            >
                Tutup
            </button>
        </div>
    </div>

    {{-- Modal Detail Notifikasi --}}
    <div
        x-show="detailModalOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 px-4 backdrop-blur-sm"
        @click.self="closeDetail()"
        @keydown.escape.window="closeDetail()"
    >
        <div
            x-show="detailModalOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
        >
            {{-- Header --}}
            <div class="relative overflow-hidden">
                <div class="absolute inset-0"
                     :class="'bg-gradient-to-r ' + notificationColor(selectedNotification?.data?.type)"
                ></div>
                <div class="relative px-6 py-5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="notificationIcon(selectedNotification?.data?.type)"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white" x-text="selectedNotification?.data?.title || 'Detail Notifikasi'"></h3>
                                <span class="inline-flex items-center gap-1.5 mt-1 text-xs font-medium text-white/80">
                                    <template x-if="selectedNotification?.type === 'laporan'">
                                        <span>📋 Laporan</span>
                                    </template>
                                    <template x-if="selectedNotification?.type === 'aspirasi'">
                                        <span>💬 Aspirasi</span>
                                    </template>
                                    <template x-if="selectedNotification?.type === 'pendaftaran'">
                                        <span>📝 Pendaftaran</span>
                                    </template>
                                    <template x-if="selectedNotification?.type === 'acara'">
                                        <span>📅 Acara</span>
                                    </template>
                                    <template x-if="selectedNotification?.type === 'struktur'">
                                        <span>👥 Struktur</span>
                                    </template>
                                    <span x-show="!selectedNotification?.read_at" class="ml-2 inline-flex h-2 w-2 rounded-full bg-white animate-pulse"></span>
                                </span>
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="closeDetail()"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur transition hover:bg-white/30"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5">
                <div class="space-y-4">
                    {{-- Pesan --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pesan</label>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700 dark:text-slate-300" x-text="selectedNotification?.data?.message || 'Tidak ada pesan'"></p>
                    </div>

                    {{-- Waktu --}}
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">
                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="formatDate(selectedNotification?.created_at)"></span>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-xs">
                            <span class="rounded-full px-2 py-0.5 font-medium"
                                  :class="selectedNotification?.read_at ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400'">
                                <span x-text="selectedNotification?.read_at ? 'Sudah dibaca' : 'Belum dibaca'"></span>
                            </span>
                        </div>
                    </div>

                    {{-- ID Notifikasi --}}
                    <div class="text-[10px] text-slate-400 dark:text-slate-500">
                        ID: <span x-text="selectedNotification?.id"></span>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 border-t border-slate-200/70 px-6 py-4 dark:border-slate-800/70">
                <template x-if="!selectedNotification?.read_at">
                    <button
                        type="button"
                        @click="markRead(selectedNotification.id); closeDetail()"
                        class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        Tandai sudah dibaca
                    </button>
                </template>
                <button
                    type="button"
                    @click="closeDetail()"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

            <button
                type="button"
                @click="toggleDarkMode()"
                class="rounded-xl p-2 text-slate-600 transition duration-300 hover:rotate-12 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                aria-label="Toggle dark mode"
            >
                <svg x-show="!darkMode" x-cloak x-transition.scale.75 class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-8.66h1M3 12H2m15.07 6.07l.7.7M6.23 6.23l.7.7m0 10.14l-.7.7m12.14-.7l-.7.7M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg x-show="darkMode" x-cloak x-transition.scale.75 class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <div class="flex items-center gap-2">
            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
                 alt="Profile"
                 class="h-8 w-8 shrink-0 rounded-full border-2 border-slate-200/50 object-cover ring-2 ring-indigo-500/10 transition hover:scale-110 hover:ring-indigo-500/30 dark:border-slate-700/50">
            <div class="hidden min-w-0 flex-col text-sm sm:flex dark:text-slate-300">
                <span class="truncate font-medium text-slate-700 dark:text-slate-200">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email ?? 'admin@himanikka.id' }}</span>
            </div>
        </div>
    </div>
</header>