<div
    x-show="$store.modal.isOpen"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
>
    <div class="relative w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900"
         @click.away="$store.modal.close()">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
            <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="$store.modal.title"></h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Detail Informasi Pengurus</p>
            </div>
            <button type="button" @click="$store.modal.close()" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="p-6 space-y-4">
            <template x-if="$store.modal.detail.photo_url">
                <div class="flex justify-center mb-4">
                    <img :src="$store.modal.detail.photo_url" alt="Foto" class="h-40 w-40 rounded-2xl object-cover shadow-lg">
                </div>
            </template>

            <div>
                <span class="font-semibold text-slate-900 dark:text-white">Nama:</span>
                <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail.user || '-'"></p>
            </div>
            <div>
                <span class="font-semibold text-slate-900 dark:text-white">Jabatan:</span>
                <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail.jabatan || '-'"></p>
            </div>
            <div>
                <span class="font-semibold text-slate-900 dark:text-white">Posisi:</span>
                <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail.posisi || '-'"></p>
            </div>
            <div>
                <span class="font-semibold text-slate-900 dark:text-white">Divisi:</span>
                <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail.devisi || '-'"></p>
            </div>
            <div>
                <span class="font-semibold text-slate-900 dark:text-white">Masa Jabatan:</span>
                <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail.masa_jabatan || '-'"></p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
            <button type="button" @click="$store.modal.close()" class="btn-secondary w-full justify-center">
                Tutup
            </button>
        </div>
    </div>
</div>