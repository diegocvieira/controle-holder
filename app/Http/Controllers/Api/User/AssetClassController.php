<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAssetClass;

class AssetClassController extends Controller
{
    public function getAssetClasses()
    {
        $userId = 1;

        $assetClasses = UserAssetClass::with([
            'assetClass' => function ($query) {
                $query->select(['id', 'name', 'slug']);
            }])
            ->where('user_id', $userId)
            ->get();

        $data = $assetClasses->map(function ($assetClass) {
            return [
                'name' => $assetClass->assetClass->name,
                'slug' => $assetClass->assetClass->slug,
                'percentage' => $assetClass->percentage,
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }
}
