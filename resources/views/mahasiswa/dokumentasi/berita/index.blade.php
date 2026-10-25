@extends('Mahasiswa.layouts.app')

@section('title', 'Dokumentasi Berita HIMANIKKA')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Dokumentasi Berita HIMANIKKA
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                Kumpulan dokumentasi berita HIMANIKKA yang dapat dilihat dan diunduh langsung.
            </p>
        </div>

        <div class="text-center py-20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <h2 class="text-2xl font-bold text-slate-700 dark:text-white mt-4">Dokumentasi Berita Segera Hadir</h2>
            <p class="text-slate-500 mt-2">Fitur dokumentasi berita masih dalam pengembangan.</p>
        </div>
    </div>
</div>
@endsection