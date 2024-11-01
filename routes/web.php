<?php

use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'layouts.app')->where('any', '.*');
