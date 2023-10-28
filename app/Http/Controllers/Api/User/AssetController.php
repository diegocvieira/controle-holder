<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserAssetRepository;
use App\Repositories\UserAssetClassRepository;
use App\Repositories\AssetRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserAssetRequest;

class AssetController extends Controller
{
    protected $userAssetRepository;
    protected $userAssetClassRepository;
    protected $assetRepository;
    protected $helper;

    public function __construct(UserAssetRepository $userAssetRepository, UserAssetClassRepository $userAssetClassRepository, AssetRepository $assetRepository, Helper $helper)
    {
        $this->userAssetRepository = $userAssetRepository;
        $this->userAssetClassRepository = $userAssetClassRepository;
        $this->assetRepository = $assetRepository;
        $this->helper = $helper;
    }

    public function getAssets(): JsonResponse
    {
        $userId = Auth::id();

        $assets = $this->userAssetRepository->getAllAssets($userId);

        $data = $assets->map(function ($asset) {
            return [
                'ticker' => $asset->asset->ticker,
                'price' => $this->helper->getPriceFromSession($asset->asset->ticker),
                'quantity' => $this->helper->formatDecimalValue($asset->quantity),
                'rating' => $this->helper->formatDecimalValue($asset->rating),
                'asset_class' => [
                    'name' => $asset->userAssetClass->assetClass->name,
                    'slug' => $asset->userAssetClass->assetClass->slug,
                    'percentage' => $asset->userAssetClass->percentage,
                ]
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(UserAssetRequest $request): JsonResponse
    {
        $userId = Auth::id();

        $request->validateMaxQuantity();

        $asset = $request->validateAsset();
        $assetClass = $request->validateAssetClass($asset->asset_class_id);

        $data = [
            'user_id' => $userId,
            'user_asset_class_id' => $assetClass->id,
            'asset_id' => $asset->id,
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ];

        $this->userAssetRepository->createAsset($data);

        $responseData = [
            'ticker' => $request->ticker,
            'rating' => $request->rating,
            'quantity' => $request->quantity,
            'asset_class_name' => $assetClass->assetClass->name,
            'asset_class_slug' => $assetClass->assetClass->slug
        ];

        return response()->json([
            'message' => trans('asset.created'),
            'data' => $responseData
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $dataToUpdate = [
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ];

        $this->userAssetRepository->updateAsset($userId, $request->ticker, $dataToUpdate);

        return response()->json([
            'message' => trans('asset.updated')
        ]);
    }

    public function delete(string $ticker): JsonResponse
    {
        $userId = Auth::id();

        $this->userAssetRepository->deleteAsset($userId, $ticker);

        return response()->json([
            'message' => trans('asset.deleted')
        ]);
    }
}
