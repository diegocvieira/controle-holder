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
        $request->session()->regenerate();

        $token = $request->user()->createToken('User Access Token');

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    public function destroy(Request $request): Response
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->user('sanctum')->currentAccessToken()->delete();

        return response()->noContent();
    }
}
