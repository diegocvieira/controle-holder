<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\AssetClass;
use App\Models\UserAssetClass;
use App\Http\Requests\User\StoreAssetClassRequest;

class AssetClassController extends Controller
{
    public function __construct(private AssetClass $assetClass, private UserAssetClass $userAssetClass)
    {
    }

    public function index(): JsonResponse
    {
        $assetClasses = $this->userAssetClass->where('user_id', auth()->id())->get();

        $data = $assetClasses->map(function ($assetClass) {
            return [
                'percentage' => $assetClass->percentage,
                'asset_class' => [
                    'name' => $assetClass->assetClass->name,
                    'slug' => $assetClass->assetClass->slug
                ]
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(StoreAssetClassRequest $request): Response
    {
        $assetClass = $this->assetClass->where('slug', $request->slug)
            ->firstOrFail();

        if ($request->percentage > 0) {
            $this->userAssetClass->updateOrCreate(
                ['user_id' => auth()->id(), 'asset_class_id' => $assetClass->id],
                ['percentage' => $request->percentage]
            );
        } else {
            $this->userAssetClass->where('user_id', auth()->id())
                ->where('asset_class_id', $assetClass->id)
                ->delete();
        }

        return response()->noContent();
    }
}
