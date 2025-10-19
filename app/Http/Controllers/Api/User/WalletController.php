<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Wallet;
use Illuminate\Support\Str;
use App\Http\Requests\User\StoreWalletRequest;

class WalletController extends Controller
{
    public function __construct(private Wallet $wallet)
    {
    }

    public function index(): JsonResponse
    {
        $wallets = $this->wallet->where('user_id', auth()->id())->get();

        $data = $wallets->map(function ($wallet) {
            return [
                'name' => $wallet->name,
                'slug' => $wallet->slug
            ];
        })->all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(StoreWalletRequest $request): JsonResponse
    {
        $wallet = $this->wallet->create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $data = [
            'name' => $wallet->name,
            'slug' => $wallet->slug
        ];

        return response()->json([
            'data' => $data
        ]);
    }
}
