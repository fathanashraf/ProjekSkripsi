@extends('admin.layouts.app')
@section('title', 'Audit Trail - Log Aktivitas HIMANIKKA')

@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-800 to-slate-900 p-6 sm:p-8 shadow-lg">
        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white/5 blur-3xl"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                    <span class="text-[11px] font-semibold text-white/80">Logging Aktif</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white">
                📋 Audit Trail
            </h1>
            <p class="mt-1 text-sm text-slate-300/80">
                Catatan seluruh aktivitas yang dilakukan oleh pengguna dalam sistem.
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-200/60 dark:border-slate-700/50 p-4 sm:p-5">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500"
                    placeholder="Cari deskripsi, module...">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Module</label>
                <select name="module"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua</option>
                    @foreach($modules as $m)
                        <option value="{{ $m }}" {{ request('module') == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Aksi</label>
                <select name="action"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua</option>
                    @foreach($actions as $a)
                        <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="sm:col-span-2 lg:col-span-5 flex justify-end gap-2">
                <a href="{{ route('admin.audit.index') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                    Reset
                </a>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                    🔍 Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Logs Table --}}
    <div class="rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-200/60 dark:border-slate-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 text-left">
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Waktu</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">User</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Aksi</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Module</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Deskripsi</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                        <td class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                            <br><span class="text-[10px]">{{ $log->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-500/20 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ substr($log->user?->name ?? '?', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white text-xs">{{ $log->user?->name ?? 'System' }}</p>
                                    <span class="text-[10px] text-slate-400">{{ $log->role }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $actionColors = [
                                    'created' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400',
                                    'updated' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                    'deleted' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400',
                                    'approved' => 'bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-400',
                                    'rejected' => 'bg-red-50 text-red-700 dark:bg-red-900/40 dark:text-red-400',
                                    'export' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-400',
                                    'login' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-400',
                                ];
                                $color = $actionColors[$log->action] ?? 'bg-slate-50 text-slate-700 dark:bg-slate-900/40 dark:text-slate-400';
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $color }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ ucfirst($log->module) }}</span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-600 dark:text-slate-400 max-w-xs truncate">
                            {{ $log->description }}
                        </td>
                        <td class="px-4 py-3 text-[10px] text-slate-400 dark:text-slate-500 font-mono">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Belum ada log aktivitas</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Log akan muncul saat ada aktivitas pengguna.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
