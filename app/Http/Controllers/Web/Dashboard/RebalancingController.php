<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RebalancingController extends Controller
{
    public function index(): View
    {
        return view('dashboard.rebalancing.index');
    }
}
