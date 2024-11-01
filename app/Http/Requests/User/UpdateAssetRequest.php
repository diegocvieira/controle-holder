<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
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
            'quantity' => ['required', 'numeric']
        ];
    }
}
