<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'percentage' => ['required', 'max:255', 'integer']
        ];
    }
}
