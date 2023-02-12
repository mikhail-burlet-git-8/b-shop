@extends('layout.auth')
@section('title', 'Восстановление пароля')

@section('content')

    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            <!-- Page heading -->
            <div class="text-center">
                <a href="/" class="inline-block" rel="home">
                    <img src="{{Vite::image('logo.svg')}}"
                         class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]"
                         alt="CutCode">
                </a>
            </div>

            <x-forms.auth-forms title="Восстановление пароля" action="{{route('password.update')}}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <x-forms.text-input
                    type="email"
                    name="email"
                    required="true"
                    placeholder="E-mail"
                    isError="{{$errors->has('email')}}"
                    value="{{request('email')}}"
                ></x-forms.text-input>

                @error('email')
                <x-forms.error class="error">{{$message}}</x-forms.error>
                @enderror


                <x-forms.text-input
                    type="password"
                    name="password"
                    required="true"
                    placeholder="Пароль"
                    isError="{{$errors->has('password')}}"
                ></x-forms.text-input>
                @error('password')
                <x-forms.error class="error">{{$message}}</x-forms.error>
                @enderror
                <x-forms.text-input
                    type="password"
                    name="password_confirmation"
                    required="true"
                    placeholder="Повторно пароль"
                    isError="{{$errors->has('password_confirmation')}}"
                ></x-forms.text-input>
                @error('password_confirmation')
                <x-forms.error class="error">{{$message}}</x-forms.error>
                @enderror
                <x-forms.primery-button>
                    Обновить пароль
                </x-forms.primery-button>
            </x-forms.auth-forms>
        </div>
    </main>

@endsection
