<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'ticker' => ['required', 'string'],
            'rating' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'asset_class' => ['required', 'exists:asset_classes,slug'],
            'wallet_slug' => ['required', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $this->validateMaxQuantity();
        $this->validateAssetAlreadyAdded();
    }

    public function validateMaxQuantity(): void
    {
        if ($this->user()->activeSubscription()) {
            return;
        }

        $count = auth()->user()->assets()->count();

        if ($count >= config('subscription.max_assets_quantity')) {
            throw ValidationException::withMessages([
                'message' => 'Atualize seu plano para cadastrar quantos ativos quiser.'
            ]);
        }
    }

    public function validateAssetAlreadyAdded(): void
    {
        $userAsset = auth()->user()->assets()
            ->whereRelation('asset', 'ticker', $this->ticker)
            ->whereRelation('userAssetClass.wallet', 'slug', $this->wallet_slug)
            ->first();

        if ($userAsset) {
            throw ValidationException::withMessages(['message' => "O ativo {$this->ticker} já foi adicionado a sua conta."]);
        }
    }
}
