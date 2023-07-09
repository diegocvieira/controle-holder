<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserAssetClassRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssetClassController extends Controller
{
    protected $userAssetClassRepository;

    public function __construct(UserAssetClassRepository $userAssetClassRepository)
    {
        $this->userAssetClassRepository = $userAssetClassRepository;
    }

    public function getAssetClasses(): JsonResponse
    {
        $userId = Auth::id();

        $assetClasses = $this->userAssetClassRepository->getAllAssetClasses($userId);

        $data = $assetClasses->map(function ($assetClass) {
            return [
                'name' => $assetClass->assetClass->name,
                'slug' => $assetClass->assetClass->slug,
                'percentage' => $assetClass->percentage,
            ];
        })->all();

        return response()->json([
            'data' => $data
        ], 200);
    }
}
