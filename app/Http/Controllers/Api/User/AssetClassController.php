<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\AssetClass;
use App\Http\Requests\User\StoreAssetClassRequest;

class AssetClassController extends Controller
{
    public function __construct(private AssetClass $assetClass)
    {
    }

    public function index(): JsonResponse
    {
        $assetClasses = auth()->user()->assetClasses()->get();

        $data = $assetClasses->map(function ($assetClass) {
            return [
                'percentage' => $assetClass->percentage,
                'asset_class' => [
                    'name' => $assetClass->assetClass->name,
                    'slug' => $assetClass->assetClass->slug
                ],
                'wallet_slug' => $assetClass->wallet->slug
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(StoreAssetClassRequest $request): Response
    {
        $assetClass = $this->assetClass->where('slug', $request->slug)->firstOrFail();
        $wallet = auth()->user()->wallets()->where('slug', $request->wallet_slug)->firstOrFail();

        if ($request->percentage > 0) {
            auth()->user()->assetClasses()->updateOrCreate(
                [
                    'asset_class_id' => $assetClass->id,
                    'wallet_id' => $wallet->id
                ], [
                    'percentage' => $request->percentage
                ]
            );
        } else {
            auth()->user()->assetClasses()
                ->where('asset_class_id', $assetClass->id)
                ->where('wallet_id', $wallet->id)
                ->delete();
        }

        return response()->noContent();
    }
}
