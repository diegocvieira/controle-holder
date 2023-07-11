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
                'message' => 'Ativo não encontrado. Entre em contato <a href="#">por aqui</a> e peça a inclusão dele no sistema.'
            ], 404);
        }

        $assetClass = $this->userAssetClassRepository->getAssetClassByAssetClassId($userId, $asset->asset_class_id);

        if (!$assetClass) {
            return response()->json([
                'success' => false,
                'message' => 'Cadastre a classe de ativos antes de adicionar o ativo.'
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

        return response()->json([
            'success' => true,
            'message' => 'Ativo adicionado com sucesso!'
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
