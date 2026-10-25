<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\AcaraAdminController;
use App\Http\Controllers\Admin\BeritaAdminController;
use App\Http\Controllers\Admin\ManajemenUserController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\StrukturAdminController;
use App\Http\Controllers\Admin\AspirasiAdminController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\DokumentasiAdminController;
use App\Http\Controllers\Admin\ProfilAdminController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\BiayaAdminController;
use App\Http\Controllers\Admin\JabatanAdminController;
use App\Http\Controllers\Admin\KeuanganAdminController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Mahasiswa\NotificationController as MahasiswaNotificationController;

// ==========================================
// NOTIFICATION ROUTES (admin & pembina)
// ==========================================
Route::middleware(['auth', 'role:admin,pembina'])->prefix('admin')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('admin.notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('admin.notifications.read-all');
});

// ==========================================
// GUEST ROUTES (belum login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'create']);
    Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.store');

    // berita (public) — partial ini hanya hidup di dalam welcome,
    // jadi arahkan ke anchor-nya, jangan render sendiri (tidak ada layout).
    Route::get('/berita', function () {
        return redirect()->route('welcome')
            ->withFragment('berita');
    })->name('berita.index');
});

// ==========================================
// AUTH ROUTES (sudah login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    // ============================================
    // ACARA
    // ============================================
    Route::prefix('acara')->group(function () {
        Route::get('/', [AcaraAdminController::class, 'index'])->name('admin.acara.index');
        Route::get('/create', [AcaraAdminController::class, 'create'])->name('admin.acara.create');
        Route::post('/store', [AcaraAdminController::class, 'store'])->name('admin.acara.store');
        Route::get('/{acara}/edit', [AcaraAdminController::class, 'edit'])->name('admin.acara.edit');
        Route::put('/{acara}/update', [AcaraAdminController::class, 'update'])->name('admin.acara.update');
        Route::delete('/{acara}/delete', [AcaraAdminController::class, 'destroy'])->name('admin.acara.destroy');
    });

    // ============================================
    // BIAYA
    // ============================================
    Route::post('/biaya/store', [BiayaAdminController::class, 'store'])->name('admin.biaya.store');

    // ============================================
    // SYARAT
    // ============================================
    Route::post('/syarat/store', [BiayaAdminController::class, 'storeSyarat'])->name('admin.syarat.store');

    // ============================================
    // BERITA
    // ============================================
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaAdminController::class, 'index'])->name('admin.berita.index');
        Route::post('/store', [BeritaAdminController::class, 'store'])->name('admin.berita.store');
        Route::put('/{berita}/update', [BeritaAdminController::class, 'update'])->name('admin.berita.update');
        Route::delete('/{berita}/delete', [BeritaAdminController::class, 'destroy'])->name('admin.berita.destroy');
    });

    // ============================================
    // MANAJEMEN USER
    // ============================================
    Route::prefix('manajemen')->group(function () {
        Route::get('/', [ManajemenUserController::class, 'index'])->name('admin.manajemen.index');
        Route::post('/store', [ManajemenUserController::class, 'store'])->name('admin.manajemen.store');
        Route::put('/{id}/update', [ManajemenUserController::class, 'update'])->name('admin.manajemen.update');
        Route::post('/{id}/delete', [ManajemenUserController::class, 'destroy'])->name('admin.manajemen.destroy');
    });

    // ============================================
    // PENDAFTARAN
    // ============================================
    Route::prefix('pendaftaran')->group(function () {
        Route::get('/', [PendaftaranAdminController::class, 'index'])->name('admin.pendaftaran.index');
        Route::post('/store', [PendaftaranAdminController::class, 'store'])->name('admin.pendaftaran.store');
        Route::put('/{pendaftaran}/update', [PendaftaranAdminController::class, 'update'])->name('admin.pendaftaran.update');
        Route::post('/{pendaftaran}/approve', [PendaftaranAdminController::class, 'approve'])->name('admin.pendaftaran.approve');
        Route::post('/{pendaftaran}/reject', [PendaftaranAdminController::class, 'reject'])->name('admin.pendaftaran.reject');
        Route::delete('/{pendaftaran}/delete', [PendaftaranAdminController::class, 'destroy'])->name('admin.pendaftaran.destroy');
    });

    // ============================================
    // STRUKTUR
    // ============================================
    Route::prefix('struktur')->group(function () {
        Route::get('/', [StrukturAdminController::class, 'index'])->name('admin.struktur.index');
        Route::get('/create', [StrukturAdminController::class, 'create'])->name('admin.struktur.create');
        Route::post('/store', [StrukturAdminController::class, 'store'])->name('admin.struktur.store');
        Route::put('/{struktur}/update', [StrukturAdminController::class, 'update'])->name('admin.struktur.update');
        Route::delete('/{struktur}/delete', [StrukturAdminController::class, 'destroy'])->name('admin.struktur.destroy');
    });

    // ============================================
    // JABATAN
    // ============================================
    Route::post('/jabatan/store', [JabatanAdminController::class, 'store'])->name('admin.jabatan.store');

    // ============================================
    // DEVISI
    // ============================================
    Route::post('/devisi/store', [JabatanAdminController::class, 'storeDevisi'])->name('admin.devisi.store');

    // ============================================
    // ASPIRASI
    // ============================================
    Route::prefix('aspirasi')->group(function () {
        Route::get('/', [AspirasiAdminController::class, 'index'])->name('admin.aspirasi.index');
        Route::post('/store', [AspirasiAdminController::class, 'store'])->name('admin.aspirasi.store');
        Route::put('/{aspirasi}/update', [AspirasiAdminController::class, 'update'])->name('admin.aspirasi.update');
        Route::delete('/{aspirasi}/delete', [AspirasiAdminController::class, 'destroy'])->name('admin.aspirasi.destroy');
    });

    // ============================================
    // LAPORAN
    // ============================================
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanAdminController::class, 'index'])->name('admin.laporan.index');
        Route::post('/store', [LaporanAdminController::class, 'store'])->name('admin.laporan.store');
        Route::put('/{laporan}/update', [LaporanAdminController::class, 'update'])->name('admin.laporan.update');
        Route::delete('/{laporan}/delete', [LaporanAdminController::class, 'destroy'])->name('admin.laporan.destroy');
    });

    // ============================================
    // DOKUMENTASI
    // ============================================
    Route::prefix('dokumentasi')->group(function () {
        Route::get('/', [DokumentasiAdminController::class, 'index'])->name('admin.dokumentasi.index');
        Route::post('/store', [DokumentasiAdminController::class, 'store'])->name('admin.dokumentasi.store');
        Route::put('/{id}/update', [DokumentasiAdminController::class, 'update'])->name('admin.dokumentasi.update');
        Route::delete('/{id}/delete', [DokumentasiAdminController::class, 'destroy'])->name('admin.dokumentasi.destroy');
    });

    // ============================================
    // KEUANGAN
    // ============================================
    Route::prefix('keuangan')->group(function () {
        Route::get('/', [KeuanganAdminController::class, 'index'])->name('admin.keuangan.index');
    });

    // ============================================
    // PROFIL
    // ============================================
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilAdminController::class, 'index'])->name('admin.profil.index');
        Route::post('/store', [ProfilAdminController::class, 'store'])->name('admin.profil.store');
        Route::put('/{profil}/update', [ProfilAdminController::class, 'update'])->name('admin.profil.update');
    });

    // ============================================
    // SERTIFIKAT
    // ============================================
    Route::prefix('sertifikat')->group(function () {
        Route::get('/', [SertifikatController::class, 'index'])->name('admin.sertifikat.index');
        Route::get('/{pendaftaranId}', [SertifikatController::class, 'show'])->name('admin.sertifikat.show');
    });


    // ============================================
    // AUDIT TRAIL
    // ============================================
    Route::get('/audit', [ExportController::class, 'auditTrail'])->name('admin.audit.index');

    // ============================================
    // EXPORT KEUANGAN
    // ============================================
    Route::get('/export-keuangan', [ExportController::class, 'keuanganCsv'])->name('admin.export.keuangan.csv');
    Route::get('/export-keuangan/xls', [ExportController::class, 'keuanganXls'])->name('admin.export.keuangan.xls');
    Route::get('/export-keuangan/pdf', [ExportController::class, 'keuanganPdf'])->name('admin.export.keuangan.pdf');

    // ============================================
    // EXPORT ACARA
    // ============================================
    Route::get('/export-acara', [ExportController::class, 'acaraCsv'])->name('admin.export.acara.csv');
    Route::get('/export-acara/xls', [ExportController::class, 'acaraXls'])->name('admin.export.acara.xls');
    Route::get('/export-acara/{acara}/pdf/{jenis?}', [ExportController::class, 'acaraPdf'])->name('admin.export.acara.pdf');

    // ============================================
    // EXPORT PENDAFTARAN
    // ============================================
    Route::get('/export-pendaftaran', [ExportController::class, 'pendaftaranCsv'])->name('admin.export.pendaftaran.csv');
    Route::get('/export-pendaftaran/xls', [ExportController::class, 'pendaftaranXls'])->name('admin.export.pendaftaran.xls');

    // ============================================
    // EXPORT LAPORAN
    // ============================================
    Route::get('/export-laporan', [ExportController::class, 'laporanCsv'])->name('admin.export.laporan.csv');
    Route::get('/export-laporan/xls', [ExportController::class, 'laporanXls'])->name('admin.export.laporan.xls');
    Route::get('/export-laporan/pdf/{id?}', [ExportController::class, 'laporanPdf'])->name('admin.export.laporan.pdf');

    // ============================================
    // EXPORT USER
    // ============================================
    Route::get('/export-user', [ExportController::class, 'userCsv'])->name('admin.export.user.csv');
    Route::get('/export-user/xls', [ExportController::class, 'userXls'])->name('admin.export.user.xls');
});

// ==========================================
// MAHASISWA ROUTES
// ==========================================
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Beranda
    Route::get('/mahasiswa', [App\Http\Controllers\Mahasiswa\BerandaController::class, 'index'])->name('Mahasiswa.beranda.index');

    // Tentang
    Route::get('/mahasiswa/tentang', [App\Http\Controllers\Mahasiswa\TentangController::class, 'index'])->name('Mahasiswa.tentang.index');

    // Struktur
    Route::get('/mahasiswa/struktur', [App\Http\Controllers\Mahasiswa\StrukturController::class, 'index'])->name('Mahasiswa.struktur.index');

    // Berita
    Route::get('/mahasiswa/berita', [App\Http\Controllers\Mahasiswa\BeritaController::class, 'index'])->name('Mahasiswa.berita.index');
    Route::post('/mahasiswa/berita/store', [App\Http\Controllers\Mahasiswa\BeritaController::class, 'store'])->name('Mahasiswa.berita.store');

    // Aspirasi
    Route::get('/mahasiswa/aspirasi', [App\Http\Controllers\Mahasiswa\AspirasiController::class, 'index'])->name('Mahasiswa.aspirasi.index');
    Route::post('/mahasiswa/aspirasi/store', [App\Http\Controllers\Mahasiswa\AspirasiController::class, 'store'])->name('Mahasiswa.aspirasi.store');

    // Acara
    Route::get('/mahasiswa/acara', [App\Http\Controllers\Mahasiswa\AcaraController::class, 'index'])->name('Mahasiswa.acara.index');
    Route::post('/mahasiswa/acara/store', [App\Http\Controllers\Mahasiswa\AcaraController::class, 'store'])->name('Mahasiswa.acara.store');

    // Dokumentasi Acara
    Route::get('/mahasiswa/dokumentasi', [App\Http\Controllers\Mahasiswa\DokumentasiAcaraController::class, 'index'])->name('Mahasiswa.dokumentasi.acara.index');

    // Dokumentasi Berita
    Route::get('/mahasiswa/dokumentasi-berita', [App\Http\Controllers\Mahasiswa\DokumentasiBeritaController::class, 'index'])->name('Mahasiswa.dokumentasi.berita.index');

    // Pendaftaran
    Route::get('/mahasiswa/pendaftaran', [App\Http\Controllers\Mahasiswa\PendaftaranController::class, 'index'])->name('Mahasiswa.pendaftaran.index');
    Route::post('/mahasiswa/pendaftaran/store', [App\Http\Controllers\Mahasiswa\PendaftaranController::class, 'store'])->name('Mahasiswa.pendaftaran.store');

    // Pembayaran
    Route::get('/mahasiswa/pembayaran', [App\Http\Controllers\Mahasiswa\PembayaranController::class, 'index'])->name('Mahasiswa.pembayaran.index');
    Route::post('/mahasiswa/pembayaran/store', [App\Http\Controllers\Mahasiswa\PembayaranController::class, 'store'])->name('Mahasiswa.pembayaran.store');

    // Profil
    Route::get('/mahasiswa/profil', [App\Http\Controllers\Mahasiswa\ProfilController::class, 'index'])->name('Mahasiswa.profil.index');

    // Sertifikat (reuse Admin\SertifikatController)
    Route::get('/mahasiswa/sertifikat', [SertifikatController::class, 'index'])->name('Mahasiswa.sertifikat.index');
    Route::get('/mahasiswa/sertifikat/{pendaftaranId}', [SertifikatController::class, 'show'])->name('Mahasiswa.sertifikat.show');

    // Notifikasi (polling status pendaftaran & pembayaran)
    Route::get('/mahasiswa/notifications', [MahasiswaNotificationController::class, 'index'])->name('mahasiswa.notifications.index');
    Route::post('/mahasiswa/notifications/read-all', [MahasiswaNotificationController::class, 'markAllRead'])->name('mahasiswa.notifications.read-all');
    Route::post('/mahasiswa/notifications/{id}/read', [MahasiswaNotificationController::class, 'markRead'])->name('mahasiswa.notifications.read');
});

// ==========================================
// PEMBINA ROUTES
// ==========================================
Route::middleware(['auth', 'role:pembina'])->prefix('pembina')->group(function () {
    // Beranda
    Route::get('/', [App\Http\Controllers\Pembina\BerandaPembinaController::class, 'index'])->name('pembina.beranda.index');

    // Tentang
    Route::get('/tentang', [App\Http\Controllers\Pembina\TentangPembinaController::class, 'index'])->name('pembina.tentang.index');

    // Struktur
    Route::get('/struktur', [App\Http\Controllers\Pembina\StrukturPembinaController::class, 'index'])->name('pembina.struktur.index');

    // Acara
    Route::get('/acara', [App\Http\Controllers\Pembina\AcaraPembinaController::class, 'index'])->name('pembina.acara.index');
    Route::post('/acara/{acara}/approve', [App\Http\Controllers\Pembina\AcaraPembinaController::class, 'approve'])->name('pembina.acara.approve');
    Route::post('/acara/{acara}/reject', [App\Http\Controllers\Pembina\AcaraPembinaController::class, 'reject'])->name('pembina.acara.reject');

    // Berita
    Route::get('/berita', [App\Http\Controllers\Pembina\BeritaPembinaController::class, 'index'])->name('pembina.berita.index');

    // Aspirasi
    Route::get('/aspirasi', [App\Http\Controllers\Pembina\AspirasiPembinaController::class, 'index'])->name('pembina.aspirasi.index');
    Route::post('/aspirasi/{aspirasi}/proses', [App\Http\Controllers\Pembina\AspirasiPembinaController::class, 'proses'])->name('pembina.aspirasi.proses');
    Route::post('/aspirasi/{aspirasi}/selesai', [App\Http\Controllers\Pembina\AspirasiPembinaController::class, 'selesai'])->name('pembina.aspirasi.selesai');
    Route::delete('/aspirasi/{aspirasi}/delete', [App\Http\Controllers\Pembina\AspirasiPembinaController::class, 'destroy'])->name('pembina.aspirasi.destroy');

    // Dokumentasi
    Route::get('/dokumentasi', [App\Http\Controllers\Pembina\DokumentasiPembinaController::class, 'index'])->name('pembina.dokumentasi.index');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Pembina\LaporanPembinaController::class, 'index'])->name('pembina.laporan.index');
    Route::post('/laporan/{laporan}/approve', [App\Http\Controllers\Pembina\LaporanPembinaController::class, 'approve'])->name('pembina.laporan.approve');
    Route::post('/laporan/{laporan}/reject', [App\Http\Controllers\Pembina\LaporanPembinaController::class, 'reject'])->name('pembina.laporan.reject');

    // Keuangan
    Route::get('/keuangan', [App\Http\Controllers\Pembina\KeuanganPembinaController::class, 'index'])->name('pembina.keuangan.index');
});
