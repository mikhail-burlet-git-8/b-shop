<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInFormRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->guest();
    }

    public function rules(): array {
        return [
            'email'    => [ 'required', 'email:dns' ],
            'password' => [ 'required' ],
        ];
    }

    public function messages(): array {
        return [
            'email.required'    => 'Поле обязательно для заполнения',
            'email.email'       => 'Введите валидный email',
            'password.required' => 'Поле обязательно для заполнения',
        ];
    }
}
