<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getData(): JsonResponse
    {
        $userId = Auth::id();

        $user = $this->userRepository->getData($userId);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function updateData(ProfileUpdateRequest $request): Response
    {
        $userId = Auth::id();

        if ($request->password) {
            $dataToUpdate = [
                'password' => Hash::make($request->password)
            ];
        } else {
            $dataToUpdate = [
                'name' => $request->name,
                'email' => $request->email
            ];
        }

        $this->userRepository->updateData($userId, $dataToUpdate);

        return response()->noContent();
    }
}
