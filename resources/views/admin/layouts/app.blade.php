<!DOCTYPE html>
<html lang="id" x-data="layoutApp()" x-init="init()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HIMANIKKA - Universitas Pahlawan Tuanku Tambusai')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logoHima-.png') }}">

    <script>
        // Terapkan tema sebelum render agar tidak berkedip (flash of light theme)
        (function () {
            var legacy = localStorage.getItem('darkMode')
            if (legacy !== null && localStorage.getItem('theme') === null) {
                localStorage.setItem('theme', legacy === 'true' ? 'dark' : 'light')
                localStorage.removeItem('darkMode')
            }
            var theme = localStorage.getItem('theme')
            var dark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)
            if (dark) document.documentElement.classList.add('dark')
        })()
    </script>

    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-900 dark:text-slate-100">
    <div
        x-show="$store.sidebar.isOpen"
        x-cloak
        class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$store.sidebar.close()"
    ></div>

    <div class="flex min-h-screen">
        @include('layouts.partials.sidebar')

        <div class="flex w-full flex-1 flex-col transition-[margin] duration-300 ease-out lg:ml-72">
            @include('layouts.partials.header')

            <main class="page-enter main-content px-0.5 pb-10 sm:px-2 md:px-3 lg:px-4 xl:px-6 2xl:px-8">
                @if (session('success'))
                    <div class="flash-success mx-1 mb-6 lg:mx-2">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500 shadow-xl">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1 text-sm leading-relaxed">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flash-error mx-1 mb-6 lg:mx-2">
                        @foreach ($errors->all() as $error)
                            <div class="mb-3 flex items-start gap-3 last:mb-0">
                                <div class="mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-xl bg-red-500 shadow-xl">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1 text-sm leading-relaxed">{{ $error }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="w-full pb-10">
                    @yield('content')
</div>
            </main>
        </div>
    </div>

    {{-- Centralized Modal --}}
    @include('layouts.partials.modal')

    @stack('scripts')
</body>
</html>