<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;

use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\User\AssetController as UserAssetController;
use App\Http\Controllers\Api\User\AssetClassController as UserAssetClassController;
use App\Http\Controllers\Api\User\RebalancingController;
use App\Http\Controllers\Api\User\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('auth/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('auth/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('auth/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('asset-classes', [UserAssetClassController::class, 'getAssetClasses']);
        Route::post('asset-classes', [UserAssetClassController::class, 'store']);

        Route::get('assets', [UserAssetController::class, 'getAssets']);
        Route::post('assets', [UserAssetController::class, 'store']);
        Route::put('assets', [UserAssetController::class, 'update']);
        Route::delete('assets/{ticker}', [UserAssetController::class, 'delete']);

        Route::get('profile', [ProfileController::class, 'getData']);
        Route::put('profile', [ProfileController::class, 'updateData']);
    });

    Route::put('rebalancing/buy', [RebalancingController::class, 'buy']);
    Route::put('rebalancing/sell', [RebalancingController::class, 'sell']);

    Route::post('prices', [PriceController::class, 'getPrice']);
});
