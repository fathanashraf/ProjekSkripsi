<!-- Login Modal - Pure Alpine -->z
<div x-data="loginModal()" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 backdrop-blur-0"
     x-transition:enter-end="opacity-100 backdrop-blur-sm"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 backdrop-blur-sm"
     x-transition:leave-end="opacity-0 backdrop-blur-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true"
     @keyup.escape="show = false"
     @click.away="show = false">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" @click.away="show = false"></div>
    
    <!-- Modal panel -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="w-full max-w-md transform overflow-hidden rounded-xl bg-white dark:bg-slate-800 p-6 text-left align-middle shadow-xl transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Masuk ke HIMANIKKA</h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 w-8 h-8 flex items-center justify-center rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 text-white py-3 px-4 rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold shadow-lg transition-all duration-200">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</div>