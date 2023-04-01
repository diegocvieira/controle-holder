<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\TargetController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('target/assets', [TargetController::class, 'assets'])->name('target.assets');
    Route::get('target/asset-classes', [TargetController::class, 'assetClasses'])->name('target.asset-classes');
});
