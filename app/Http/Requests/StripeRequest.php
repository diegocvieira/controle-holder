<?php

namespace App\Http\Requests;

use Stripe\Event;
use Stripe\Webhook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StripeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getStripeEvent(): Event
    {
        $endpointSecret = config('services.stripe.webhook_secret');
        $payload = $this->getContent();
        $sigHeader = $this->header('Stripe-Signature');

        try {
            return Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['message' => 'Stripe webhook error.']);
        }
    }
}
