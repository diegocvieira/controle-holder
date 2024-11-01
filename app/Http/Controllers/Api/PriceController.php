<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Utils\AssetUtil;

class PriceController extends Controller
{
    public function __construct(private AssetUtil $assetUtil)
    {
    }

    public function getPrice(Request $request): JsonResponse
    {
        $price = $this->assetUtil->getScrapingPrice($request->asset_class, $request->ticker);

        return response()->json([
            'data' => [
                'price' => $price
            ]
        ]);
    }
}
