<?php

use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FaceRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page — tampil untuk tamu, redirect ke dashboard jika sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Devices
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');

    // Access Logs
    Route::get('/logs', [AccessLogController::class, 'index'])->name('logs.index');

    // Face Registration
    Route::get('/face', [FaceRegistrationController::class, 'index'])->name('face.index');
    Route::post('/face', [FaceRegistrationController::class, 'store'])->name('face.store');
    Route::post('/face/cancel', [FaceRegistrationController::class, 'cancel'])->name('face.cancel');

    // Admin only
    Route::middleware('role:admin')->group(function () {

        // Devices — CRUD (create harus sebelum {device} agar tidak tertimpa)
        Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
        Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
        Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
        Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
        Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
        Route::post('/devices/{device}/regenerate-token', [DeviceController::class, 'regenerateToken'])->name('devices.regenerate-token');

        // Jam Operasional
        Route::post('/devices/{device}/operational-hours', [DeviceController::class, 'storeOperationalHours'])->name('devices.operational-hours.store');
        Route::put('/devices/{device}/operational-hours/{hour}', [DeviceController::class, 'updateOperationalHours'])->name('devices.operational-hours.update');
        Route::delete('/devices/{device}/operational-hours/{hour}', [DeviceController::class, 'destroyOperationalHours'])->name('devices.operational-hours.destroy');

        // Hapus Log
        Route::delete('/logs/{log}', [AccessLogController::class, 'destroy'])->name('logs.destroy');
        Route::delete('/logs', [AccessLogController::class, 'destroyAll'])->name('logs.destroyAll');

        // Settings — Notifikasi
        Route::post('/settings/notifications', [SettingController::class, 'update'])->name('settings.notifications');

        // Users — CRUD (tanpa show)
        Route::resource('users', UserController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';