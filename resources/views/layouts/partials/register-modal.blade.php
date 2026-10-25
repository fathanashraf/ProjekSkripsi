<!-- Register Modal -->
<div id="register-modal"
     tabindex="-1"
     aria-hidden="true"
     class="hidden fixed inset-0 z-50 h-full w-full overflow-y-auto overflow-x-hidden p-4">
    <div class="relative mx-auto mt-10 w-full max-w-2xl">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm dark:bg-slate-950/80" data-modal-backdrop="static"></div>

        <!-- Panel -->
        <div class="relative rounded-2xl bg-white shadow-2xl dark:bg-slate-800">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-700">
                <div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                        Daftar Akun Baru
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Isi data berikut untuk membuat akun baru.
                    </p>
                </div>

                <button type="button"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-700 dark:hover:text-white"
                        data-modal-hide="register-modal">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13"></path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form action="{{ route('auth.register') }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">NIM</label>
                    <input type="text" name="NIM" value="{{ old('NIM') }}"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    @error('NIM')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                    <select name="status" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Pilih status</option>
                        <option value="pengunjung" {{ old('status') == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                        <option value="mahasiswa" {{ old('status') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="pengurus" {{ old('status') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                        <option value="dosen" {{ old('status') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="demisioner" {{ old('status') == 'demisioner' ? 'selected' : '' }}>Demisioner</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Avatar</label>
                    <input type="file" name="avatar" accept="image/*"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-indigo-700 hover:file:bg-indigo-100 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:file:bg-slate-600 dark:file:text-white">
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-2.5 font-semibold text-white transition hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                    Daftar
                </button>
            </form>
        </div>
    </div>
</div>