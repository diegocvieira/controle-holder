<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAssetClass;
use App\Repositories\UserAssetClassRepository;

class AssetClassController extends Controller
{
    protected $userAssetClassRepository;

    public function __construct(UserAssetClassRepository $userAssetClassRepository)
    {
        $this->userAssetClassRepository = $userAssetClassRepository;
    }

    public function getAssetClasses()
    {
        $assetClasses = $this->userAssetClassRepository->getAllAssetClasses(1); // TODO change 1 for user auth id

        $data = $assetClasses->map(function ($assetClass) {
            return [
                'name' => $assetClass->assetClass->name,
                'slug' => $assetClass->assetClass->slug,
                'percentage' => $assetClass->percentage,
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }
}
