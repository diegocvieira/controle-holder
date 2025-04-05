<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();
        $token = $user->createToken('User Access Token')->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function destroy(Request $request): Response
    {
        $request->user('sanctum')->currentAccessToken()->delete();

        return response()->noContent();
    }
}
