<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\AssetClassController;
use App\Http\Controllers\Api\User\AssetClassController as UserAssetClassController;
use App\Http\Controllers\Api\User\AssetController as UserAssetController;
use App\Http\Controllers\Api\PriceController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::get('/asset-classes', [AssetClassController::class, 'index'])->middleware('auth:sanctum');

Route::post('/prices', [PriceController::class, 'getPrice'])->middleware('auth:sanctum');

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::prefix('asset-classes')->controller(UserAssetClassController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });

    Route::prefix('assets')->controller(UserAssetController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/', 'update');
        Route::delete('/{asset}', 'destroy');
    });
});
