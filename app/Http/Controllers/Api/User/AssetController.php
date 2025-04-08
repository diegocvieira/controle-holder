<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Asset;
use App\Models\UserAsset;
use App\Models\UserAssetClass;
use App\Http\Requests\User\StoreAssetRequest;
use App\Http\Requests\User\UpdateAssetRequest;
use App\Http\Utils\AssetUtil;
use Illuminate\Validation\ValidationException;

class AssetController extends Controller
{
    public function __construct(private Asset $asset, private UserAssetClass $userAssetClass, private UserAsset $userAsset, private AssetUtil $assetUtil)
    {
    }

    public function index(): JsonResponse
    {
        $assets = $this->userAsset->with('userAssetClass')
            ->where('user_id', auth()->id())
            ->get();

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
                ]
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(StoreAssetRequest $request): Response
    {
        $assetClass = $this->userAssetClass->whereRelation('assetClass', 'slug', $request->asset_class)->firstOrFail();
        $asset = $this->asset->where('ticker', $request->ticker)->first();

        if (!$asset) {
            if ($request->asset_class === 'renda-fixa') {
                $assetName = $request->ticker;
            } else {
                $assetName = $this->assetUtil->getScrapingName($request->asset_class, $request->ticker);

                if (!$assetName) {
                    throw ValidationException::withMessages(['message' => "O ativo {$request->ticker} não foi encontrado dentro dessa classe de ativos selecionada."]);
                }
            }

            $asset = $this->asset->create([
                'asset_class_id' => $assetClass->asset_class_id,
                'name' => $assetName,
                'ticker' => strtoupper($request->ticker)
            ]);
        }

        $request->validateAssetAlreadyAdded($asset->id);

        $this->userAsset->create([
            'user_id' => auth()->id(),
            'user_asset_class_id' => $assetClass->id,
            'asset_id' => $asset->id,
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ]);

        return response()->noContent();
    }

    public function update(UpdateAssetRequest $request): Response
    {
        $this->userAsset->where('user_id', auth()->id())
            ->whereRelation('asset', 'ticker', $request->ticker)
            ->update([
                'quantity' => $request->quantity,
                'rating' => $request->rating
            ]);

        return response()->noContent();
    }

    public function destroy(string $ticker): Response
    {
        $this->userAsset->where('user_id', auth()->id())
            ->whereRelation('asset', 'ticker', $ticker)
            ->delete();

        return response()->noContent();
    }
}
