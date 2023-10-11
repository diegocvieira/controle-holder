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

    public function __construct(UserAssetRepository $userAssetRepository, UserAssetClassRepository $userAssetClassRepository, AssetRepository $assetRepository)
    {
        $this->userAssetRepository = $userAssetRepository;
        $this->userAssetClassRepository = $userAssetClassRepository;
        $this->assetRepository = $assetRepository;
    }

    public function getAssets(): JsonResponse
    {
        $userId = Auth::id();

        $assets = $this->userAssetRepository->getAllAssets($userId);

        $data = $assets->map(function ($asset) {
            return [
                'ticker' => $asset->asset->ticker,
                'price' => Helper::getPriceFromSession($asset->asset->ticker),
                'quantity' => Helper::formatDecimalValue($asset->quantity),
                'rating' => Helper::formatDecimalValue($asset->rating),
                'asset_class' => [
                    'name' => $asset->userAssetClass->assetClass->name,
                    'slug' => $asset->userAssetClass->assetClass->slug,
                    'percentage' => $asset->userAssetClass->percentage,
                ]
            ];
        })->all();

        return response()->json(['data' => $data], 200);
    }

    public function store(UserAssetRequest $request): JsonResponse
    {
        $userId = Auth::id();

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
            'success' => true,
            'message' => 'Ativo adicionado com sucesso!',
            'data' => $responseData
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $dataToUpdate = [
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ];

        $this->userAssetRepository->updateAsset($userId, $request->ticker, $dataToUpdate);

        return response()->json([], 204);
    }
}
