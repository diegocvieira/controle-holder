<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class RebalancingController extends Controller
{
    public function buy(Request $request): Response
    {
        $asset = auth()->user()->assets()
            ->whereRelation('asset', 'ticker', $request->ticker)
            ->whereRelation('userAssetClass.wallet', 'slug', $request->wallet_slug)
            ->firstOrFail();

        $newQuantity = $asset->quantity + (int) $request->quantity;

        $asset->update([
            'quantity' => $newQuantity
        ]);

        return response()->noContent();
    }

    public function sell(Request $request): Response
    {
        $asset = auth()->user()->assets()
            ->whereRelation('asset', 'ticker', $request->ticker)
            ->whereRelation('userAssetClass.wallet', 'slug', $request->wallet_slug)
            ->firstOrFail();

        $newQuantity = (int) $asset->quantity - $request->quantity;

        if ($newQuantity < 0) {
            throw ValidationException::withMessages(['message' => 'Quantidade insuficiente para vender.']);
        }

        $asset->update([
            'quantity' => $newQuantity
        ]);

        return response()->noContent();
    }
}
