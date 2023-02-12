<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotFormRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->guest();
    }

    public function rules(): array {
        return [
            'email' => [ 'required', 'email:dns' ],
        ];
    }

    public function messages(): array {
        return [
            'email.required' => 'Поле обязательно для заполнения',
            'email.email'    => 'Введите валидный email',
            'email.user'     => 'Мы не можем найти пользователя с таким адресом электронной почты.',
        ];
    }
}
