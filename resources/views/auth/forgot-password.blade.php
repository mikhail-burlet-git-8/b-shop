@extends('layout.auth')
@section('title', 'Забыли пароль')

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
            <x-forms.auth-forms title="Забыли пароль" action="{{route('forgot.handle')}}" method="post">
                @csrf
                <x-forms.text-input
                    type="email"
                    name="email"
                    required="true"
                    placeholder="E-mail"
                    isError="{{$errors->has('email')}}"
                    value="{{old('email')}}"
                ></x-forms.text-input>

                @error('email')
                <x-forms.error class="error">{{$message}}</x-forms.error>
                @enderror

                <x-forms.primery-button>
                    Отправить
                </x-forms.primery-button>

                <x-slot:buttons>
                    <div class="space-y-3 mt-5">
                        <div class="text-xxs md:text-xs">
                            <a href="lost-password.html" class="text-white hover:text-white/70 font-bold">
                                Забыли пароль?
                            </a>
                        </div>
                        <div class="text-xxs md:text-xs">
                            <a href="{{route('login.page')}}"
                               class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a>
                        </div>
                    </div>
                </x-slot:buttons>
            </x-forms.auth-forms>
        </div>
    </main>

@endsection
