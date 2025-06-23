<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Asset;
use App\Http\Utils\AssetUtil;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAssetRequest;
use App\Http\Requests\User\UpdateAssetRequest;
use App\Http\Requests\User\DestroyAssetRequest;
use Illuminate\Validation\ValidationException;

class AssetController extends Controller
{
    public function __construct(private Asset $asset, private AssetUtil $assetUtil)
    {
    }

    public function index(): JsonResponse
    {
        $assets = auth()->user()->assets()->get();

        $data = $assets->map(function ($asset) {
            return [
                'ticker' => $asset->asset->ticker,
                'price' => $this->assetUtil->getPriceFromCache($asset->userAssetClass->assetClass->slug, $asset->asset->ticker),
                'quantity' => $asset->quantity,
                'rating' => $asset->rating,
                'asset_class' => [
                    'name' => $asset->userAssetClass->assetClass->name,
                    'slug' => $asset->userAssetClass->assetClass->slug,
                    'percentage' => $asset->userAssetClass->percentage,
                    'wallet' => $asset->userAssetClass->wallet->slug
                ]
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(StoreAssetRequest $request): Response
    {
        $assetClass = auth()->user()->assetClasses()
            ->whereRelation('assetClass', 'slug', $request->asset_class)
            ->whereRelation('wallet', 'slug', $request->wallet_slug)
            ->firstOrFail();

        $asset = $this->asset->where('ticker', $request->ticker)->first();

        if (!$asset) {
            if ($request->asset_class === 'renda-fixa') {
                $assetName = $request->ticker;
            } else {
                $assetName = $this->assetUtil->getScrapingName($request->asset_class, $request->ticker);

                if (!$assetName) {
                    throw ValidationException::withMessages(['message' => "O ativo {$request->ticker} não foi encontrado dentro da classe de ativos selecionada."]);
                }
            }

            $asset = $this->asset->create([
                'asset_class_id' => $assetClass->asset_class_id,
                'name' => $assetName,
                'ticker' => strtoupper($request->ticker)
            ]);
        }

        auth()->user()->assets()->create([
            'user_asset_class_id' => $assetClass->id,
            'asset_id' => $asset->id,
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ]);

        return response()->noContent();
    }

    public function update(UpdateAssetRequest $request): Response
    {
        auth()->user()->assets()
            ->whereRelation('asset', 'ticker', $request->ticker)
            ->whereRelation('userAssetClass.wallet', 'slug', $request->wallet_slug)
            ->update([
                'quantity' => $request->quantity,
                'rating' => $request->rating
            ]);

        return response()->noContent();
    }

    public function destroy(string $ticker, DestroyAssetRequest $request): Response
    {
        auth()->user()->assets()
            ->whereRelation('asset', 'ticker', $ticker)
            ->whereRelation('userAssetClass.wallet', 'slug', $request->wallet_slug)
            ->delete();

        return response()->noContent();
    }
}
