<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAsset;
use App\Models\UserAssetClass;
use App\Models\Asset;
use App\Helpers\Helper;

class AssetController extends Controller
{
    public function getAssets()
    {
        $userId = 1;

        $assets = UserAsset::with([
                'asset' => function ($query) {
                    $query->select(['id', 'ticker']);
                },
                'userAssetClass.assetClass' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                },
            ])
            ->where('user_id', $userId)
            ->get();

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

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $userId = 1;

        $asset = Asset::where('ticker', $request->ticker)->first();

        if (!$asset) {
            return response()->json([
                'success' => false
            ], 404);
        }

        $assetClass = UserAssetClass::with('assetClass')
            ->whereHas('assetClass', function ($query) use ($request) {
                $query->where('slug', $request->asset_class_slug);
            })
            ->where('user_id', $userId)
            ->first();

        UserAsset::create([
            'user_id' => $userId,
            'user_asset_class_id' => $assetClass->id,
            'asset_id' => $asset->id,
            'quantity' => $request->quantity,
            'rating' => $request->rating
        ]);

        return response()->json([
            'success' => true
        ], 204);
    }

    public function update(Request $request)
    {
        $userId = 1;

        UserAsset::with('asset')
            ->whereHas('asset', function ($query) use ($request) {
                $query->where('ticker', $request->ticker);
            })
            ->where('user_id', $userId)
            ->update([
                'quantity' => $request->quantity,
                'rating' => $request->rating
            ]);

        return response()->json([
            'success' => true
        ], 204);
    }
}
