<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'active'     => ['required'],
            'address'     => ['required', 'string'],
            'role_id'     => ['required'],
            'phone'     => ['required', 'string'],
            'email'    => ['required', 'email', Rule::unique('users')],
            // 'password' => ['required', 'string', Rules\Password::defaults()],
            'password' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
