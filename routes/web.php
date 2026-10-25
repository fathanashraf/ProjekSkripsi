<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\welcomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', [welcomeController::class, 'index'])->name('welcome');

Route::get('/pendaftaran', [welcomeController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
Route::post('/pendaftaran', [welcomeController::class, 'pendaftaranStore'])->name('pendaftaran.store');

Route::post('/acara', [welcomeController::class, 'acara'])->name('acara.store');

Route::post('/berita', [welcomeController::class, 'berita'])->name('berita.store');

Route::post('/aspirasi', [welcomeController::class, 'aspirasi'])->name('aspirasi.store');

// pembayaran
Route::get('/pembayaran', [welcomeController::class, 'pembayaranIndex'])->name('pembayaran.index');
Route::post('/pembayaran', [welcomeController::class, 'pembayaranStore'])->name('pembayaran.store');

// profil publik
Route::get('/profil', [welcomeController::class, 'tentangKami'])->name('profil.show');

// profil user (yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/user/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/user/profil/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/user/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/user/profil/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
});


require __DIR__.'/auth.php';
