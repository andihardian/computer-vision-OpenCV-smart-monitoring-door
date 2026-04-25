<?php

use App\Http\Controllers\Api\DoorController;
use Illuminate\Support\Facades\Route;

Route::post('/door/unlock', [DoorController::class, 'unlock']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/door/logs', [DoorController::class, 'logs']);
});