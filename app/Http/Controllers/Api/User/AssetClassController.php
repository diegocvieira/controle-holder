<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserAssetClassRepository;
use App\Repositories\AssetClassRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AssetClassController extends Controller
{
    protected $userAssetClassRepository;
    protected $sssetClassRepository;

    public function __construct(UserAssetClassRepository $userAssetClassRepository, AssetClassRepository $assetClassRepository)
    {
        $this->userAssetClassRepository = $userAssetClassRepository;
        $this->assetClassRepository = $assetClassRepository;
    }

    public function getAssetClasses(): JsonResponse
    {
        $userId = Auth::id();

        $assetClasses = $this->assetClassRepository->getAll();
        $userAssetClasses = $this->userAssetClassRepository->getAllAssetClasses($userId);

        $data = [];
        $userAssetClassesDict = [];

        foreach ($userAssetClasses as $userAssetClass) {
            $userAssetClassesDict[$userAssetClass->asset_class_id] = $userAssetClass->percentage;
        }

        foreach ($assetClasses as $assetClass) {
            $data[] = [
                'name' => $assetClass->name,
                'slug' => $assetClass->slug,
                'percentage' => isset($userAssetClassesDict[$assetClass->id]) ? $userAssetClassesDict[$assetClass->id] : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request): Response
    {
        $userId = Auth::id();
        $assetClassId = $this->assetClassRepository->getBySlug($request->slug)->id;

        $this->userAssetClassRepository->save($userId, $assetClassId, $request->percentage);

        return response()->noContent();
    }
}
