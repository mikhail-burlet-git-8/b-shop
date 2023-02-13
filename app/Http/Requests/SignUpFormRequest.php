<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignUpFormRequest extends FormRequest {

    public function authorize(): bool {
        return auth()->guest();
    }

    public function rules(): array {
        return [
            'name'     => [ 'required', 'string', 'min:1' ],
            'email'    => [ 'required', 'email:dns', 'unique:users' ],
            'password' => [ 'required', 'confirmed', Password::defaults() ],
        ];
    }

    public function messages(): array {
        return [
            'name.required'      => 'Поле "Имя" обязательно для заполнения',
            'email.required'     => 'Поле "Email" обязательно для заполнения',
            'email.email'        => 'Введите правильный email адрес',
            'email.unique'       => 'Такой email уже существует',
            'password.required'  => 'Поле обязательно для заполнения',
            'password.confirmed' => 'Подтверждение пароля не совпадает.',
            'password.min'       => 'Пароль должен быть не меньше 8 символов',
        ];
    }

    protected function prepareForValidation() {
        $this->merge( [
            'email' => str( request( 'email' ) )
                ->squish()
                ->lower()
                ->value()
        ] );
    }

}
