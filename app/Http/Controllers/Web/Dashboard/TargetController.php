<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TargetController extends Controller
{
    public function assets(): View
    {
        return view('dashboard.target.assets');
    }

    public function assetClasses(): View
    {
        return view('dashboard.target.asset-classes');
    }
}
