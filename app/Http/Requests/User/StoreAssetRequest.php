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

    public function validateAssetAlreadyAdded(int $assetId): void
    {
        $userAsset = $this->userAsset->where('user_id', auth()->id())
            ->where('asset_id', $assetId)
            ->first();

        if ($userAsset) {
            throw ValidationException::withMessages(['message' => "O ativo {$this->ticker} já foi adicionado a sua conta."]);
        }
    }
}
