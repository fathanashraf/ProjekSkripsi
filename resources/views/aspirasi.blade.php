<div class="mx-auto max-w-6xl px-4">
        <div class="mb-16 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border-2 border-indigo-300 bg-indigo-50 px-6 py-2.5 text-sm font-bold text-indigo-700 dark:text-indigo-300">Aspirasi Mahasiswa</span>
            <h2 class="mt-6 text-5xl font-extrabold text-slate-900 dark:text-white">Sampaikan <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Aspirasi Anda</span></h2>
            <p class="mx-auto mt-6 max-w-3xl text-xl text-slate-600 dark:text-slate-400">K Kritik, saran, dan masukan untuk pengurus HIMANIKKA.</p>
        </div>

        @if(session('success'))
        <div class="mb-8 rounded-2xl bg-emerald-50 p-6 text-emerald-700 border-2 border-emerald-200">{{ session('success') }}</div>
        @endif

        <div class="rounded-[2.5rem] bg-white p-10 shadow-2xl dark:bg-slate-900 border border-slate-200">
            <form method="POST" action="{{ route('aspirasi.store') }}">
                @csrf
                <input type="hidden" name="Masukkan" value="aspirasi">
                <textarea name="Masukkan" rows="8" required class="w-full rounded-2xl border-2 border-slate-300 px-6 py-5 text-lg outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 dark:bg-slate-950 dark:border-slate-700" placeholder="Tuliskan aspirasi Anda..."></textarea>
                <button type="submit" class="mt-6 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-10 py-4 text-lg font-bold text-white hover:scale-105">Kirim Aspirasi</button>
            </form>
        </div>
    </div>