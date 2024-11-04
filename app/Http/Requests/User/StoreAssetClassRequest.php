<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserAssetClass;
use Illuminate\Validation\ValidationException;

class StoreAssetClassRequest extends FormRequest
{
    public function __construct(protected UserAssetClass $userAssetClass)
    {
        parent::__construct();
        $this->userAssetClass = $userAssetClass;
    }

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'max:255', 'string'],
            'percentage' => ['required', 'max:255', 'integer']
        ];
    }

    protected function passedValidation(): void
    {
        $this->validateTotalPercentage();
    }

    protected function validateTotalPercentage(): void
    {
        $currentAssetClass = $this->userAssetClass->where('user_id', auth()->id())
            ->whereRelation('assetClass', 'slug', $this->slug)
            ->first();

        $currentPercentage = $currentAssetClass ? $currentAssetClass->percentage : 0;

        $total = $this->userAssetClass->where('user_id', auth()->id())->sum('percentage');
        $adjustedTotal = $total - $currentPercentage + $this->percentage;

        if ($adjustedTotal > 100) {
            throw ValidationException::withMessages(['message' => 'A soma das alocações não pode exceder 100%.']);
        }
    }
}
