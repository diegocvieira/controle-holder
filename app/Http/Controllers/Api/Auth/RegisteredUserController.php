<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function __construct(private User $user)
    {
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $user = $this->user->create([
                'uuid' => Str::uuid()->toString(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $user->wallets()->create([
                'name' => 'Carteira global',
                'slug' => 'carteira-global'
            ]);
        });

        return response()->json([], 201);
    }
}
