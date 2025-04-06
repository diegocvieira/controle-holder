<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function __construct(private User $user)
    {
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $this->user->create([
            'uuid' => Str::uuid()->toString(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json([], 201);
    }
}
