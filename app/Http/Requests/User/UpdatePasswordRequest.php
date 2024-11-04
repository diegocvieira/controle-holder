<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'max:255', 'confirmed', Rules\Password::defaults()],
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail(__('validation.current_password'));
                    }
                }
            ]
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw ValidationException::withMessages([
            'message' => $validator->errors()->first()
        ]);
    }
}
