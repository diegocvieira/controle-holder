<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserAssetRepository;
use Illuminate\Support\Facades\Auth;

class RebalancingController extends Controller
{
    protected $userAssetRepository;

    public function __construct(UserAssetRepository $userAssetRepository)
    {
        $this->userAssetRepository = $userAssetRepository;
    }

    public function buy(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $asset = $this->userAssetRepository->getAssetByTicker($userId, $request->ticker);

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'Ativo não encontrado.'
            ], 404);
        }

        $newQuantity = $asset->quantity + (int) $request->quantity;
        $dataToUpdate = ['quantity' => $newQuantity];
        $this->userAssetRepository->updateAsset($userId, $request->ticker, $dataToUpdate);

        return response()->json([], 204);
    }

    public function sell(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $asset = $this->userAssetRepository->getAssetByTicker($userId, $request->ticker);

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'Ativo não encontrado.'
            ], 404);
        }

        $newQuantity = (int) $asset->quantity - $request->quantity;

        if ($newQuantity < 0) {
            return response()->json([
                'success' => false,
                'Quantidade insuficiente para vender.'
            ], 400);
        }

        $dataToUpdate = ['quantity' => $newQuantity];
        $this->userAssetRepository->updateAsset($userId, $request->ticker, $dataToUpdate);

        return response()->json([], 204);
    }
}
