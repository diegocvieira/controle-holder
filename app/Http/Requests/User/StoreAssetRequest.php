<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\UserAsset;

class StoreAssetRequest extends FormRequest
{
    public function __construct(protected UserAsset $userAsset)
    {
        parent::__construct();
        $this->userAsset = $userAsset;
    }

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
            'asset_class' => ['required', 'exists:asset_classes,slug']
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

        $count = $this->userAsset->where('user_id', auth()->id())->count();

        if ($count >= config('subscription.max_assets_quantity')) {
            throw ValidationException::withMessages([
                'message' => 'Atualize seu plano para cadastrar quantos ativos quiser.'
            ]);
        }
    }

    public function validateAssetAlreadyAdded(): void
    {
        $userAsset = $this->userAsset->where('user_id', auth()->id())
            ->whereRelation('asset', 'ticker', $this->ticker)
            ->first();

        if ($userAsset) {
            throw ValidationException::withMessages(['message' => "O ativo {$this->ticker} já foi adicionado a sua conta."]);
        }
    }
}
