<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'O e-mail ou senha não correspondem a nenhuma conta cadastrada.'
        ], 404);
    }

    public function destroy(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true
        ], 200);
    }
}
