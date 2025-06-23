<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreWalletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }

    protected function passedValidation(): void
    {
        $this->validateSubscription();
    }

    public function validateSubscription(): void
    {
        if ($this->user()->activeSubscription()) {
            return;
        }

        throw ValidationException::withMessages([
            'message' => 'Atualize seu plano para cadastrar quantas carteiras quiser.'
        ]);
    }
}
