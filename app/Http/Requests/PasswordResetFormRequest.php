<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetFormRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->guest();
    }

    public function rules(): array {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array {

        return [
            'email.required'     => 'Поле обязательно для заполнения',
            'email.email'        => 'Мы не можем найти пользователя с таким адресом электронной почты',
            'password.required'  => 'Поле обязательно для заполнения',
            'password.min'       => 'Минимальное количество знаков 8',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
