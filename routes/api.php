<?php

use App\Http\Controllers\Api\DoorController;
use App\Http\Controllers\Api\UserIdentifierController;
use App\Http\Controllers\Api\FaceRequestController;
use App\Http\Controllers\Api\SettingApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::post('/door/unlock', [DoorController::class, 'unlock']);
    Route::get('/users/identifiers', [UserIdentifierController::class, 'index']);
    Route::get('/settings/notifications', [SettingApiController::class, 'notifications']);

    // Face Registration API
    Route::get('/face-requests/pending', [FaceRequestController::class, 'pending']);
    Route::post('/face-requests/{id}/processing', [FaceRequestController::class, 'processing']);
    Route::post('/face-requests/{id}/progress', [FaceRequestController::class, 'updateProgress']);
    Route::get('/face-requests/{id}/cancelled', [FaceRequestController::class, 'checkCancelled']);
    Route::post('/face-requests/{id}/done', [FaceRequestController::class, 'done']);
    Route::post('/face-requests/{id}/failed', [FaceRequestController::class, 'failed']);
    Route::get('/face-requests/{id}/status', [FaceRequestController::class, 'status']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/door/logs', [DoorController::class, 'logs']);
});