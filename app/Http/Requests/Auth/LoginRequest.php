<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\AuthenticationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required']
        ];
    }

    public function authenticate(): void
    {
        if (!auth()->attempt($this->only('email', 'password'), true)) {
            throw new AuthenticationException(__('auth.failed'));
        }
    }
}
