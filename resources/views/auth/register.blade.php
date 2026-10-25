@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div
    x-data="{ loading: false, password: '', confirmPassword: '' }"
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-4"
>

    <div class="w-full max-w-md" data-aos="fade-up">

        <!-- CARD -->
        <div class="w-full max-w-lg rounded-3xl bg-white p-8 shadow-2xl dark:bg-slate-900">

            <!-- HEADER -->
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 mb-2">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    Register Akun
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Silakan isi data dengan benar
                </p>
            </div>

            <!-- ERROR -->
            @if(session('error'))
                <div class="flash-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="flash-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FORM -->
            <form
                action="{{ route('auth.register') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4"
                @submit="loading = true"
            >
                @csrf

                <!-- NAME -->
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: John Doe" value="{{ old('name') }}" class="form-input" required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label class="form-label">NIM <span class="text-slate-400 dark:text-slate-500">(opsional)</span></label>
                    <input type="text" name="NIM" placeholder="Contoh: 12345678" value="{{ old('NIM') }}" class="form-input">
                    @error('NIM')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NO HP -->
                <div>
                    <label class="form-label">No HP</label>
                    <input type="text" name="No_hp" placeholder="Contoh: 08123456789" value="{{ old('No_hp') }}" class="form-input">
                    @error('No_hp')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ALAMAT -->
                <div>
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" placeholder="Contoh: Jl. Merdeka No. 123, Jakarta" rows="3" class="form-input">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ROLE -->
                <div>
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-input" required>
                        <option disabled selected value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" placeholder="Contoh: john@example.com" value="{{ old('email') }}" class="form-input" required>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- AVATAR -->
                <div x-data="{ preview: null }">
                    <label class="form-label">Avatar <span class="text-slate-400 dark:text-slate-500">(opsional)</span></label>

                    <input type="file" name="avatar" accept="image/*" class="form-input" @change="
                            const file = $event.target.files[0];
                            preview = file ? URL.createObjectURL(file) : null;
                        ">
                    <p class="form-help">JPG/PNG/WEBP, maksimal 8MB</p>

                    <template x-if="preview">
                        <div class="mt-3 flex justify-center">
                            <img :src="preview" class="h-24 w-24 rounded-full border-2 border-indigo-300 object-cover shadow-lg dark:border-indigo-600">
                        </div>
                    </template>

                    @error('avatar')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" x-model="password" placeholder="Minimal 8 karakter" class="form-input" required>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CONFIRM PASSWORD -->
                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" x-model="confirmPassword" placeholder="Ulangi password" class="form-input" required>

                    <p x-show="password && confirmPassword && password !== confirmPassword" class="form-error mt-2 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Password tidak sama
                    </p>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="btn-primary w-full justify-center py-4"
                    :disabled="loading || password !== confirmPassword">

                    <span x-show="!loading" class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Daftar
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

            <!-- LOGIN -->
            <div class="text-center text-sm text-slate-500 dark:text-slate-400">
                Sudah punya akun?
                <a href="{{ route('auth.login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                    Login
                </a>
            </div>

        </div>
    </div>
</div>
@endsection