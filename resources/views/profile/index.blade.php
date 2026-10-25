@php
    $roleName = auth()->user()->role ? strtolower(auth()->user()->role->name) : '';
    $isAdmin = $roleName === 'kahim' || $roleName === 'admin';
@endphp

@extends($isAdmin ? 'admin.layouts.app' : 'layouts.app')

@section('title', 'Profil User')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 shadow-xl">
        <div class="px-6 py-8 sm:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-[11px] font-medium tracking-wide text-white/80 ring-1 ring-white/15">
                        Profil Pengguna
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-white/75 sm:text-base">
                        Kelola data akun, avatar, dan password Anda dalam satu halaman.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:min-w-[280px] lg:grid-cols-1">
                    <div class="rounded-2xl bg-white/10 px-4 py-3 text-sm text-white/85 ring-1 ring-white/15 backdrop-blur">
                        <span class="block text-[11px] uppercase tracking-wider text-white/60">Role</span>
                        <span class="mt-1 block font-semibold capitalize">{{ auth()->user()->role_id ? ucfirst(auth()->user()->role->name) : '-' }}</span>
                    </div>

                    <div class="rounded-2xl bg-white/10 px-4 py-3 text-sm text-white/85 ring-1 ring-white/15 backdrop-blur">
                        <span class="block text-[11px] uppercase tracking-wider text-white/60">Status</span>
                        <span class="mt-1 block font-semibold capitalize">{{ auth()->user()->status ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-12">

        {{-- Sidebar Profil --}}
        <div class="xl:col-span-4">
            <div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-col items-center text-center">

                    <div x-data="{ open: false }" class="relative">
                        <div
                            class="h-24 w-24 cursor-pointer overflow-hidden rounded-full bg-slate-100 ring-4 ring-slate-100 dark:bg-slate-800 dark:ring-slate-800"
                            @click="open = true"
                        >
                            <img
                                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
                                alt="Avatar"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <span class="absolute bottom-1 right-1 h-3.5 w-3.5 rounded-full bg-emerald-500 ring-4 ring-white dark:ring-slate-900"></span>

                        <div
                            x-show="open"
                            x-transition.opacity
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                            @click.self="open = false"
                            @keydown.escape.window="open = false"
                            style="display: none;"
                        >
                            <div class="w-full max-w-sm rounded-3xl bg-white p-5 shadow-2xl dark:bg-slate-900">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Foto Profil Anda</h3>
                                    <button
                                        type="button"
                                        class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                                        @click="open = false"
                                    >
                                        ✕
                                    </button>
                                </div>

                                <div class="flex justify-center">
                                    <img
                                        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
                                        alt="Avatar Preview"
                                        class="h-52 w-52 rounded-2xl object-cover ring-4 ring-slate-100 dark:ring-slate-800"
                                    >
                                </div>

                                <div class="mt-4 text-center">
                                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                        {{ auth()->user()->name }}
                                    </h2>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ auth()->user()->email }}
                                    </p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ auth()->user()->status ?? '-' }}
                                    </p>
                                </div>

<div class="mt-5">
    <a
        href="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-placeholder.svg') }}"
        download
        class="block rounded-full bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white transition hover:bg-slate-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-200"
    >
        Download Foto Profil
    </a>
</div>
                            </div>
                        </div>
                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-slate-900 dark:text-slate-100">
                        {{ auth()->user()->name }}
                    </h2>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ auth()->user()->email }}
                    </p>

                    <div class="mt-3 inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        {{ ucfirst(auth()->user()->role_id) ? ucfirst(auth()->user()->role->name) : 'Mahasiswa' }}
                    </div>

                    <div class="mt-5 w-full space-y-3 text-left">
                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">
                            <div class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400">NIM</div>
                            <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
                                {{ auth()->user()->NIM ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">
                            <div class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400">alamat</div>
                            <div class="mt-1 text-sm font-medium capitalize text-slate-900 dark:text-slate-100">
                                {{ auth()->user()->alamat ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">
                            <div class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400">Email</div>
                            <div class="mt-1 break-all text-sm font-medium text-slate-900 dark:text-slate-100">
                                {{ auth()->user()->email }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">
                            <div class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400">No. Hp</div>
                            <div class="mt-1 break-all text-sm font-medium text-slate-900 dark:text-slate-100">
                                {{ auth()->user()->No_hp ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <form
                        action="{{ route('profile.avatar.upload') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-5 w-full space-y-3 text-left"
                    >
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Ganti Avatar
                            </label>

                            <input
                                type="file"
                                name="avatar"
                                accept="image/*"
                                class="block w-full rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-white hover:file:bg-blue-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                            >

                            @error('avatar')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-slate-100 dark:text-slate-900">
                            Upload Avatar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Form Update --}}
        <div class="space-y-6 xl:col-span-8">

            <div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Update Profil</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Perbarui nama, NIM, email, dan alamat akun Anda.
                    </p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">NIM</label>
                        <input type="text" name="NIM" value="{{ old('NIM', auth()->user()->NIM) }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('NIM')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">No. Hp</label>
                        <input type="text" name="No_hp" value="{{ old('No_hp', auth()->user()->No_hp) }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('No_hp')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">alamat</label>
                        <input name="alamat" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        </input>
                        @error('status')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 flex justify-end pt-1">
                        <button class="rounded-2xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Ganti Password</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Gunakan password baru yang kuat dan aman.
                    </p>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Password Saat Ini</label>
                        <input type="password" name="confirmation_password" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('confirmation_password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Password Baru</label>
                        <input type="password" name="password" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    </div>

                    <div class="sm:col-span-2 flex justify-end pt-1">
                        <button class="rounded-2xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection