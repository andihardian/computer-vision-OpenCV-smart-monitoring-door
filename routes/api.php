<?php

use App\Http\Controllers\Api\DoorController;
use App\Http\Controllers\Api\UserIdentifierController;
use Illuminate\Support\Facades\Route;

// Endpoint untuk Raspberry Pi
// Dilindungi rate limiting: maksimal 30 request per menit
Route::middleware('throttle:30,1')->group(function () {
    Route::post('/door/unlock', [DoorController::class, 'unlock']);
    Route::get('/users/identifiers', [UserIdentifierController::class, 'index']);
});

// Endpoint logs hanya untuk user yang sudah login
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/door/logs', [DoorController::class, 'logs']);
});