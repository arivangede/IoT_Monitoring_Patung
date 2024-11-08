<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login based on authentication
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Route protected by auth and verify middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [AuthController::class, 'verifyindex'])->name('verify.email.notice');
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verify.email.request');
    Route::post('/verify-email/send-email', [AuthController::class, 'resendVerificationEmail'])
        ->name('verify.email.send');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// Auth routes for login, register, and logout
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
