<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    private $stripe;

    public function __construct(private Subscription $subscription)
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function scheduleCancelation(Request $request): JsonResponse
    {
        $subscription = $this->subscription->where('user_id', auth()->id())
            ->where('status', $this->subscription::PAID_STATUS)
            ->firstOrFail();

        $response = $this->stripe->subscriptions->update($subscription->subscription_id, ['cancel_at_period_end' => true]);

        $periodEnd = Carbon::createFromTimestamp($response->current_period_end)->setTimezone('America/Sao_Paulo');

        $subscription->update([
            'cancel_at' => $periodEnd->toDateTimeString()
        ]);

        return response()->json([
            'data' => [
                'cancel_at' => $periodEnd->format('d/m/Y')
            ]
        ]);
    }

    public function resumeSubscription(Request $request): Response
    {
        $subscription = $this->subscription->where('user_id', auth()->id())
            ->where('status', $this->subscription::PAID_STATUS)
            ->firstOrFail();

        $this->stripe->subscriptions->update($subscription->subscription_id, ['cancel_at_period_end' => false]);

        $subscription->update([
            'cancel_at' => null
        ]);

        return response()->noContent();
    }
}
