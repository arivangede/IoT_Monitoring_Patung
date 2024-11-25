<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailHistoryController;
use App\Http\Controllers\EmailReceiverController;
use App\Http\Controllers\IoTController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login based on authentication
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Route for sensors
Route::get('/sensors', [IoTController::class, 'getCurrentSensorsData'])->name('sensors.current.data');
Route::get('/sensors/all', [IoTController::class, 'getAllSensorsData'])->name('sensors.all.data');

Route::get('/email-receivers/verify-email/{id}/{hash}', [EmailReceiverController::class, 'verifyEmail'])->name('email.receiver.verify');

// Route protected by auth and verify middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::get('/email-histories', [EmailHistoryController::class, 'getAll'])->name('email.histories');
    Route::post('/email-histories/remove-history/{id}', [EmailHistoryController::class, 'destroy'])->name('email.history.destroy');
    Route::get('/email-receivers', [EmailReceiverController::class, 'getAll'])->name('email.receivers');
    Route::post('/email-receivers/create', [EmailReceiverController::class, 'store'])->name('email.receiver.create');
    Route::post('/email-receivers/remove-email/{id}', [EmailReceiverController::class, 'destroy'])->name('email.receiver.destroy');


    Route::get('/user-settings', [UserSettingsController::class, 'index'])->name('user-settings');
    Route::patch('/user-settings/{id}', [UserSettingsController::class, 'update'])->name('user.update');
    Route::patch('/user-settings/change-password/{id}', [UserSettingsController::class, 'change_password'])->name('user.change.password');
    Route::patch('/user-settings/delete-account/{id}', [UserSettingsController::class, 'delete_account'])->name('user.delete.account');
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

    Route::get('/forgot-password', [AuthController::class, 'forgotIndex'])->name('forgot.password.index');
    Route::post('/forgot-password', [AuthController::class, 'forgotSend'])->name('forgot.password.request');
    Route::get('/reset-password', [AuthController::class, 'resetPasswordIndex'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});
