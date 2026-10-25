@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div
    x-data="{ loading: false }"
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-4"
>
    <div class="w-full max-w-md" data-aos="fade-up">

        <!-- CARD -->
        <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl dark:bg-slate-900">

            <!-- HEADER -->
            <div class="text-center space-y-3">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg">
                    <img src="{{ asset('assets/logoHima-.png') }}" alt="Logo HIMANIKKA" class="w-10 h-10 object-contain">
                </div>

                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    Selamat Datang
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Login ke sistem informasi HIMANIKKA
                </p>
            </div>

            <!-- ERROR SESSION -->
            @if(session('error'))
                <div class="flash-error">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="flash-success">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- FORM -->
            <form
                action="{{ route('auth.login') }}"
                method="POST"
                class="space-y-4"
                @submit="loading = true"
            >
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="form-input"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="form-input"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- REMEMBER + FORGOT -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex cursor-pointer items-center gap-2 text-slate-600 dark:text-slate-300">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700">
                        <span>Ingat saya</span>
                    </label>

                    <a href="{{ route('forgot-password') }}"
                       class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                        Lupa password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="btn-primary w-full justify-center py-4"
                    :disabled="loading"
                >
                    <span x-show="!loading" class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login
                    </span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 004 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </form>

            <!-- FOOTER -->
            <div class="text-center text-sm text-slate-500 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('auth.register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                    Daftar
                </a>
            </div>

        </div>
    </div>
</div>
@endsection