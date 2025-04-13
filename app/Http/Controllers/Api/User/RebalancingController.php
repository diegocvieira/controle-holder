<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserAsset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAssetRequest;
use Illuminate\Validation\ValidationException;

class RebalancingController extends Controller
{
    public function __construct(private UserAsset $userAsset)
    {
    }

    public function buy(Request $request): Response
    {
        $asset = $this->userAsset->where('user_id', auth()->id())
            ->whereRelation('asset', 'ticker', $request->ticker)
            ->firstOrFail();

        $newQuantity = $asset->quantity + (int) $request->quantity;

        $asset->update([
            'quantity' => $newQuantity
        ]);

        return response()->noContent();
    }

    public function sell(Request $request): Response
    {
        $asset = $this->userAsset->where('user_id', auth()->id())
            ->whereRelation('asset', 'ticker', $request->ticker)
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
