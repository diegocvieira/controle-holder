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
                'quantity' => $asset->quantity,
                'rating' => $asset->rating,
                'asset_class' => [
                    'name' => $asset->userAssetClass->assetClass->name,
                    'slug' => $asset->userAssetClass->assetClass->slug,
                    'percentage' => $asset->userAssetClass->percentage,
                ]
            ];
        })->all();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $asset = $this->assetRepository->getAssetByTicker($request->ticker);

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'O ativo não foi encontrado no nosso sistema. Solicite a inclusão dele.'
            ], 404);
        }

        $assetClass = $this->userAssetClassRepository->getClassBySlug($userId, $request->asset_class_slug);

        if (!$assetClass) {
            return response()->json([
                'success' => false,
                'message' => 'A classe de ativos não foi encontrada no nosso sistema.'
            ], 404);
        }

        $data = [
            'user_id' => $userId,
            'user_asset_class_id' => $assetClass->id,
            'asset_id' => $asset->id,
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ];

        $this->userAssetRepository->createAsset($data);

        return response()->json([], 204);
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
