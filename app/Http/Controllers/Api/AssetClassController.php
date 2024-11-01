<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\AssetClass;

class AssetClassController extends Controller
{
    public function __construct(private AssetClass $assetClass)
    {
    }

    public function index(): JsonResponse
    {
        $data = $this->assetClass->select('name', 'slug')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
