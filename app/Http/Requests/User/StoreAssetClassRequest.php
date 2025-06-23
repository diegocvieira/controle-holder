<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreAssetClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'max:255', 'string'],
            'percentage' => ['required', 'max:255', 'integer'],
            'wallet_slug' => ['required', 'max:255', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $this->validateTotalPercentage();
    }

    protected function validateTotalPercentage(): void
    {
        $currentAssetClass = auth()->user()->assetClasses()
            ->whereRelation('assetClass', 'slug', $this->slug)
            ->whereRelation('wallet', 'slug', $this->wallet_slug)
            ->first();

        $currentPercentage = $currentAssetClass ? $currentAssetClass->percentage : 0;

        $total = auth()->user()->assetClasses()
            ->whereRelation('wallet', 'slug', $this->wallet_slug)
            ->sum('percentage');
        $adjustedTotal = $total - $currentPercentage + $this->percentage;

        if ($adjustedTotal > 100) {
            throw ValidationException::withMessages(['message' => 'A soma das alocações não pode exceder 100%.']);
        }
    }
}
