<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;

// ==========================================
// PUBLIC API (tidak perlu auth)
// ==========================================

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now()->toDateTimeString(),
    ]);
});

// ==========================================
// AUTH (tidak perlu token)
// ==========================================
Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::post('/register', [AuthController::class, 'register'])
    ->name('api.register');

// ==========================================
// MIDTRANS WEBHOOK (tidak perlu auth)
// ==========================================
Route::post('/payment/midtrans-notification', [PaymentController::class, 'midtransNotification'])
    ->name('api.payment.midtrans-notification');

// ==========================================
// AUTHENTICATED API (perlu Bearer token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {

    // ---- User ----
    Route::get('/user', [AuthController::class, 'user'])
        ->name('api.user');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::delete('/logout-all', [AuthController::class, 'logoutAll'])
        ->name('api.logout-all');

    // ---- Payment ----
    Route::post('/payment/snap-token', [PaymentController::class, 'getSnapToken'])
        ->name('api.payment.snap-token');

    Route::post('/payment/store', [PaymentController::class, 'store'])
        ->name('api.payment.store');

    Route::get('/payment/status/{pendaftaran_id}', [PaymentController::class, 'status'])
        ->name('api.payment.status');
});
