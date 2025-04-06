<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Models\User;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct(private User $user)
    {
    }

    public function show(): JsonResponse
    {
        $user = $this->user->with('subscriptions')->findOrFail(auth()->id());
        $subscription = $user->activeSubscription() ?? null;

        $data = [
            'id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'current_plan' => $subscription->plan_code ?? 'FREE',
            'current_plan_cancel_at' => isset($subscription->cancel_at) ? Carbon::parse($subscription->cancel_at)->format('d/m/Y') : ''
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): Response
    {
        $this->user->where('id', auth()->id())
            ->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

        return response()->noContent();
    }

    public function updatePassword(UpdatePasswordRequest $request): Response
    {
        $this->user->findOrFail(auth()->id())
            ->update([
                'password' => $request->password
            ]);

        return response()->noContent();
    }
}
