<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Http\Requests\StripeRequest;
use Illuminate\Http\Response;

class StripeWebhookController extends Controller
{
    public function __construct(private User $user, private Subscription $subscription)
    {
    }

    public function handleCheckoutCompleted(StripeRequest $request): Response
    {
        $event = $request->getStripeEvent();
        $data = $event->data->object;

        $user = $this->user->where('uuid', $data->client_reference_id)->firstOrFail();

        $user->subscriptions()->create([
            'subscription_id' => $data->subscription,
            'status' => $data->payment_status,
            'plan_code' => $data->metadata->plan_code
        ]);

        return response()->noContent();
    }

    public function handleSubscriptionCanceled(StripeRequest $request): Response
    {
        $event = $request->getStripeEvent();
        $data = $event->data->object;

        $subscription = $this->subscription->where('subscription_id', $data->id)->firstOrFail();

        $subscription->update([
            'status' => $data->status
        ]);

        return response()->noContent();
    }
}
