<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Web\Dashboard\TargetController;
use App\Http\Controllers\Web\Dashboard\RebalancingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('target/assets', [TargetController::class, 'assets'])->name('target.assets');
    Route::get('target/asset-classes', [TargetController::class, 'assetClasses'])->name('target.asset-classes');
    Route::get('rebalancing', [RebalancingController::class, 'index'])->name('rebalancing');
});
