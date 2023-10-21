<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Dashboard\TargetController;
use App\Http\Controllers\Web\Dashboard\RebalancingController;
use App\Http\Controllers\Web\Dashboard\ProfileController;

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
})->name('home');

Route::get('pricing', function () {
    return view('pricing');
})->name('pricing');

Route::group(['prefix' => 'legal', 'as' => 'legal.'], function () {
    Route::get('terms-of-service', function () {
        return view('terms-of-service');
    })->name('terms-of-service');

    Route::get('privacy-policy', function () {
        return view('privacy-policy');
    })->name('privacy-policy');
});

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('target/assets', [TargetController::class, 'assets'])->name('target.assets');
    Route::get('target/asset-classes', [TargetController::class, 'assetClasses'])->name('target.asset-classes');

    Route::get('rebalancing', [RebalancingController::class, 'index'])->name('rebalancing');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
});
