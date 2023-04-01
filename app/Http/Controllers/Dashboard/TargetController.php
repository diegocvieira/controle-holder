<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function assets()
    {
        return view('dashboard.target.assets');
    }

    public function assetClasses()
    {
        return view('dashboard.target.asset-classes');
    }
}
