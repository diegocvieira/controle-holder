<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\User\AssetController;
use App\Http\Controllers\Api\User\AssetClassController;

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

Route::get('asset-classes', [AssetClassController::class, 'getAssetClasses']);

Route::get('assets', [AssetController::class, 'getAssets']);
Route::post('assets', [AssetController::class, 'store']);
Route::put('assets', [AssetController::class, 'update']);

Route::post('prices', [PriceController::class, 'getPrice']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
