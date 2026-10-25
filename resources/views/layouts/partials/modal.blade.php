<div x-data
     x-show="$store.modal.isOpen"
     x-cloak
     @keydown.escape.window="$store.modal.close()"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm">

    <div @click.away="$store.modal.close()"
         x-show="$store.modal.isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         :class="{
             'max-w-md': $store.modal.size === 'sm',
             'max-w-lg': $store.modal.size === 'md',
             'max-w-xl': $store.modal.size === 'lg',
             'max-w-2xl': $store.modal.size === 'xl',
             'max-w-3xl': $store.modal.size === '2xl',
             'max-w-4xl': $store.modal.size === '3xl',
             'max-w-5xl': $store.modal.size === '4xl',
             'max-w-6xl': $store.modal.size === '5xl',
             'max-w-7xl': $store.modal.size === 'full',
         }"
         class="relative flex w-auto min-w-[280px] sm:min-w-[320px] max-h-[85vh] flex-col overflow-hidden rounded-3xl bg-white shadow-2xl dark:border-slate-700/40 dark:bg-slate-900">

        {{-- HEADER --}}
        <div class="flex-shrink-0 border-b border-slate-200 px-6 py-5 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white" x-text="$store.modal.title"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400" x-show="$store.modal.subtitle" x-text="$store.modal.subtitle"></p>
                    <p class="text-sm text-slate-500 dark:text-slate-400" x-show="$store.modal.message && $store.modal.mode !== 'confirm'" x-text="$store.modal.message"></p>
                </div>
                <button type="button" @click="$store.modal.close()"
                    class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- BODY (scrollable) --}}
        <div class="flex-1 overflow-y-auto scrollbar-thin p-6">

            {{-- ============================ --}}
            {{-- FORM MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'form'">
                <form :action="$store.modal.formAction"
                      method="POST"
                      :enctype="$store.modal.enctype">
                    @csrf

                    <template x-if="$store.modal.method !== 'POST'">
                        <input type="hidden" name="_method" :value="$store.modal.method">
                    </template>

                    <div class="space-y-2.5">
                        <template x-for="(field, index) in $store.modal.fields" :key="index">
                            <div :class="field.full === true ? 'col-span-full' : ''">
                                <label class="form-label mb-1.5 flex items-center gap-2" x-show="field.type !== 'hidden' && field.label">
                                    <span x-text="field.label"></span>
                                    <span x-show="field.required === true"
                                        class="rounded-md bg-rose-50 px-1.5 py-0.5 text-[10px] font-semibold text-rose-500 dark:bg-rose-950/40 dark:text-rose-400">
                                        Wajib
                                    </span>
                                </label>

                                {{-- Text / Email / Password / Number / Date --}}
                                <template x-if="['text', 'email', 'password', 'number', 'date', 'tel', 'url'].includes(field.type)">
                                    <div class="relative">
                                        <template x-if="field.icon">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                                <svg class="h-4 w-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        </template>
                                        <input
                                            :type="field.type || 'text'"
                                            :name="field.name"
                                            :required="field.required === true"
                                            :placeholder="field.placeholder || ''"
                                            :value="$store.modal.form[field.name] || ''"
                                            @input="$store.modal.form[field.name] = $event.target.value"
                                            :class="field.icon ? 'pl-10' : ''"
                                            class="form-input"
                                        >
                                    </div>
                                </template>

                                {{-- Textarea --}}
                                <template x-if="field.type === 'textarea'">
                                    <textarea
                                        :name="field.name"
                                        :required="field.required === true"
                                        :placeholder="field.placeholder || ''"
                                        :rows="field.rows || 3"
                                        x-model="$store.modal.form[field.name]"
                                        class="form-input resize-y min-h-[90px]"
                                    ></textarea>
                                </template>

                                {{-- Select with custom dropdown arrow --}}
                                <template x-if="field.type === 'select'">
                                    <select
                                        :name="field.name"
                                        :required="field.required === true"
                                        x-model="$store.modal.form[field.name]"
                                        class="form-input appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9Im5vbmUiIHZpZXdCb3g9IjAgMCAyNCAyNCIgc3Ryb2tlPSIjOTQ5NkExIj48cGF0aCBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgZD0iTTE5IDlsLTcgNy03LTciLz48L3N2Zz4=')] bg-[length:1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-10">
                                        <option value="">— Pilih —</option>
                                        <template x-for="opt in (field.options || [])" :key="opt.value">
                                            <option :value="opt.value" x-text="opt.label"></option>
                                        </template>
                                    </select>
                                </template>

                                {{-- File upload with dropzone style --}}
                                <template x-if="field.type === 'file'">
                                    <div class="group relative">
                                        <div class="flex items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/50 px-4 py-6 transition-all duration-200 hover:border-indigo-400 hover:bg-indigo-50/30 dark:border-slate-700 dark:bg-slate-800/30 dark:hover:border-indigo-500 dark:hover:bg-indigo-950/20">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                                    <span class="font-medium text-indigo-600 dark:text-indigo-400">Klik untuk upload</span> atau seret file ke sini
                                                </p>
                                                <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500" x-show="field.accept">Format: <span x-text="field.accept"></span></p>
                                            </div>
                                        </div>
                                        <input
                                            type="file"
                                            :name="field.name"
                                            :accept="field.accept || '*/*'"
                                            :multiple="field.multiple === true"
                                            @change="$store.modal.form[field.name] = field.multiple ? $event.target.files : $event.target.files[0]"
                                            class="absolute inset-0 cursor-pointer opacity-0"
                                        >
                                    </div>
                                </template>

                                {{-- Checkbox --}}
                                <template x-if="field.type === 'checkbox'">
                                    <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition-all duration-200 hover:border-indigo-300 hover:bg-indigo-50/30 dark:border-slate-700 dark:hover:border-indigo-600 dark:hover:bg-indigo-950/20">
                                        <input
                                            type="checkbox"
                                            :name="field.name"
                                            :checked="$store.modal.form[field.name] === true || $store.modal.form[field.name] === '1'"
                                            @change="$store.modal.form[field.name] = $event.target.checked"
                                            class="h-5 w-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700"
                                        >
                                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300" x-text="field.label || field.name"></span>
                                    </label>
                                </template>

                                {{-- Hidden --}}
                                <input type="hidden" :name="field.name" :value="$store.modal.form[field.name] || ''" x-show="field.type === 'hidden'">

                                {{-- Help text --}}
                                <p class="form-help" x-show="field.help" x-text="field.help"></p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4 flex items-center justify-end gap-2 border-t border-slate-100 pt-3 dark:border-slate-800">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-4 py-2 text-xs">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary px-4 py-2 text-xs">
                            Simpan
                        </button>
                    </div>
                </form>
            </template>

            {{-- ============================ --}}
            {{-- DETAIL MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'detail'">
                <div class="space-y-4">
                    <template x-for="(field, index) in $store.modal.fields" :key="index">
                        <div>
                            {{-- Image type --}}
                            <template x-if="field.type === 'image'">
                                <div class="flex justify-center">
                                    <template x-if="$store.modal.detail[field.key]">
                                        <div class="rounded-2xl overflow-hidden shadow-lg">
                                            <img :src="$store.modal.detail[field.key]"
                                                 :alt="field.label"
                                                 class="h-48 w-full object-cover"
                                                 x-on:error="$el.style.display='none'">
                                        </div>
                                    </template>
                                </div>
                            </template>

                            {{-- Text / default --}}
                            <template x-if="!['image'].includes(field.type)">
                                <div>
                                    <span class="font-semibold text-slate-900 dark:text-white" x-text="field.label + ':'"></span>

                                    {{-- Link type --}}
                                    <template x-if="field.type === 'link'">
                                        <template x-if="$store.modal.detail[field.key]">
                                            <a :href="$store.modal.detail[field.key]"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="block text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                Lihat File
                                            </a>
                                        </template>
                                        <template x-if="!$store.modal.detail[field.key]">
                                            <p class="text-slate-700 dark:text-slate-300">-</p>
                                        </template>
                                    </template>

                                    {{-- Textarea type --}}
                                    <template x-if="field.type === 'textarea'">
                                        <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail[field.key] || '-'"></p>
                                    </template>

                                    {{-- Status badge type --}}
                                    <template x-if="field.type === 'status'">
                                        <p>
                                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium"
                                                  :class="{
                                                      'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300': ['Aktif','Active','Lunas','Selesai','Dibayar'].includes($store.modal.detail[field.key]),
                                                      'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300': ['Pending','Menunggu'].includes($store.modal.detail[field.key]),
                                                      'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300': ['Nonaktif','Tidak Aktif','Belum Dibayar'].includes($store.modal.detail[field.key]),
                                                      'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300': ['Akan Datang','Informasi','Cash'].includes($store.modal.detail[field.key]),
                                                      'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300': !$store.modal.detail[field.key]
                                                  }"
                                                  x-text="$store.modal.detail[field.key] || '-'">
                                            </span>
                                        </p>
                                    </template>

                                    {{-- Nominal/Price type --}}
                                    <template x-if="field.type === 'nominal'">
                                        <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="$store.modal.detail[field.key] || '-'"></p>
                                    </template>

                                    {{-- Default text type --}}
                                    <template x-if="!['link', 'textarea', 'status', 'nominal'].includes(field.type)">
                                        <p class="text-slate-700 dark:text-slate-300" x-text="$store.modal.detail[field.key] || '-'"></p>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>

                </div>
            </template>

            {{-- ============================ --}}
            {{-- CONFIRM MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'confirm'">
                <div class="py-3 text-center">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-50 to-orange-50 shadow-inner dark:from-amber-950/30 dark:to-orange-950/20">
                        <svg class="h-6 w-6 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white" x-text="$store.modal.title"></h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500 dark:text-slate-400" x-text="$store.modal.message"></p>
                    <div class="mt-4 flex items-center justify-center gap-2">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-4 py-2 text-xs">
                            Batal
                        </button>
                        <button type="button" @click="$store.modal.confirm()" :disabled="$store.modal.loading"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-rose-600 to-red-600 px-4 py-2 text-xs font-semibold text-white shadow shadow-rose-500/20 transition-all duration-200 hover:from-rose-700 hover:to-red-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg x-show="$store.modal.loading" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <span x-text="$store.modal.loading ? 'Memproses...' : 'Ya, Hapus'"></span>
                        </button>
                    </div>
                </div>
            </template>

            {{-- ============================ --}}
            {{-- PREVIEW MODE (file/image/pdf/video/audio) --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'preview'">
                <div>
                    <template x-if="$store.modal.fileType === 'image'">
                        <img :src="$store.modal.fileUrl" :alt="$store.modal.fileName" class="mx-auto max-h-[70vh] rounded-xl object-contain shadow-lg">
                    </template>
                    <template x-if="$store.modal.fileType === 'video'">
                        <video :src="$store.modal.fileUrl" controls class="w-full max-h-[70vh] rounded-xl shadow-lg"></video>
                    </template>
                    <template x-if="$store.modal.fileType === 'audio'">
                        <div class="flex flex-col items-center justify-center rounded-xl bg-slate-50 p-8 dark:bg-slate-800">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-950/40 dark:to-purple-950/30">
                                <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                            </div>
                            <audio :src="$store.modal.fileUrl" controls class="w-full max-w-md"></audio>
                        </div>
                    </template>
                    <template x-if="$store.modal.fileType === 'pdf'">
                        <iframe :src="$store.modal.fileUrl" class="w-full h-[70vh] rounded-xl shadow-lg"></iframe>
                    </template>
                    <template x-if="!['image','video','audio','pdf'].includes($store.modal.fileType)">
                        <div class="flex flex-col items-center justify-center rounded-xl bg-slate-50 py-12 dark:bg-slate-800">
                            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600">
                                <svg class="h-10 w-10 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300" x-text="$store.modal.fileName || 'File'"></p>
                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Klik tombol di bawah untuk mengunduh</p>
                            <a :href="$store.modal.fileUrl" target="_blank"
                               class="mt-4 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-indigo-500/20 transition-all duration-200 hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download File
                            </a>
                        </div>
                    </template>
                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-6 py-2.5">Tutup</button>
                    </div>
                </div>
            </template>

            {{-- ============================ --}}
            {{-- YOUTUBE MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'youtube'">
                <div>
                    <div class="aspect-video w-full overflow-hidden rounded-xl shadow-lg">
                        <iframe :src="$store.modal.youtubeUrl" class="h-full w-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-6 py-2.5">Tutup</button>
                    </div>
                </div>
            </template>

            {{-- ============================ --}}
            {{-- IFRAME MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'iframe'">
                <div>
                    <iframe :src="$store.modal.iframeUrl" class="h-[70vh] w-full rounded-xl shadow-lg"></iframe>
                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-6 py-2.5">Tutup</button>
                    </div>
                </div>
            </template>

            {{-- ============================ --}}
            {{-- GALLERY MODE --}}
            {{-- ============================ --}}
            <template x-if="$store.modal.mode === 'gallery'">
                <div>
                    <template x-if="$store.modal.gallery.length > 0">
                        <div class="relative">
                            <div class="overflow-hidden rounded-xl shadow-lg">
                                <img :src="$store.modal.gallery[$store.modal.galleryIndex]"
                                     alt="Gallery image"
                                     class="w-full max-h-[60vh] object-contain bg-slate-100 dark:bg-slate-800 transition-opacity duration-300"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100">
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <button @click="$store.modal.prevImage()" x-show="$store.modal.galleryIndex > 0"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition-all duration-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                    <span x-text="$store.modal.galleryIndex + 1"></span>
                                    <span class="text-slate-300 dark:text-slate-600">/</span>
                                    <span x-text="$store.modal.gallery.length"></span>
                                </span>
                                <button @click="$store.modal.nextImage()" x-show="$store.modal.galleryIndex < $store.modal.gallery.length - 1"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition-all duration-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                                    Selanjutnya
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                            {{-- Thumbnail strip --}}
                            <div class="mt-3 flex justify-center gap-2 overflow-x-auto py-2 scrollbar-thin">
                                <template x-for="(img, idx) in $store.modal.gallery" :key="idx">
                                    <button @click="$store.modal.galleryIndex = idx"
                                        :class="{
                                            'ring-2 ring-indigo-500 ring-offset-2 dark:ring-offset-slate-900 opacity-100 scale-105': idx === $store.modal.galleryIndex,
                                            'opacity-60 hover:opacity-90': idx !== $store.modal.galleryIndex
                                        }"
                                        class="h-12 w-16 flex-shrink-0 overflow-hidden rounded-lg transition-all duration-200 hover:scale-105">
                                        <img :src="img" alt="" class="h-full w-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="$store.modal.close()" class="btn-secondary px-6 py-2.5">Tutup</button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Detail mode footer --}}
        <template x-if="$store.modal.mode === 'detail'">
            <div class="flex-shrink-0 border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                <button type="button" @click="$store.modal.close()" class="btn-secondary w-full justify-center">
                    Tutup
                </button>
            </div>
        </template>

        {{-- Loading overlay --}}
        <template x-if="$store.modal.loading">
            <div class="absolute inset-0 z-10 flex items-center justify-center rounded-2xl bg-white/60 backdrop-blur-sm dark:bg-slate-900/60">
                <div class="flex items-center gap-3 rounded-xl bg-white px-5 py-3 shadow-xl dark:bg-slate-800">
                    <svg class="h-5 w-5 animate-spin text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Memproses...</span>
                </div>
            </div>
        </template>
    </div>
</div>