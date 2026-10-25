{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html
    lang="id"
    x-data="layoutApp()"
    x-init="init()"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'HIMANIKKA - Universitas Pahlawan Tuanku Tambusai')
    </title>

    <meta
        name="description"
        content="Website Resmi HIMANIKKA Universitas Pahlawan Tuanku Tambusai"
    >

    <link rel="icon" href="{{ asset('assets/logoHima-.png') }}">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

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

<body
    class="min-h-screen bg-slate-50 text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-900 dark:text-slate-100"
>
<div x-cloak class="flex min-h-screen flex-col">

    {{-- Navbar --}}
    @include('layouts.partials.navbarQuest')

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mx-auto mt-4 w-full max-w-7xl px-4">
            <div class="flash-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-auto mt-4 w-full max-w-7xl px-4">
            <div class="flash-error">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="page-enter flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Centralized Modal --}}
    @include('layouts.partials.modal')

</div>

@stack('scripts')

</body>
</html>