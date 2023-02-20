@extends('layout.auth')
@section('title', 'Регистрация')

@section('content')

    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            <div class="text-center">
                <a href="/" class="inline-block" rel="home">
                    <img src="{{Vite::image('logo.svg')}}"
                         class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]"
                         alt="">
                </a>
            </div>

            <x-forms.auth-forms title="Регистрация" method="post" action="{{route('register.handle')}}">
                @csrf
                @method('post')
                <x-forms.text-input
                    type="text"
                    name="name"
                    required="true"
                    placeholder="Имя и фамилия"
                    isError="{{$errors->has('name')}}"
                    value="{{old('name')}}"
                ></x-forms.text-input>
                @error('name')
                <x-forms.error class="error">{{$message}}</x-forms.error>
                @enderror
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
                    Зарегистрироватся
                </x-forms.primery-button>

                <x-slot:socialAuth>
                    <ul class="space-y-3 mt-3">
                        <li>
                            <a href="{{route('socialite.redirect', 'github')}}"
                               class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
                                <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 0C4.475 0 0 4.475 0 10a9.994 9.994 0 0 0 6.838 9.488c.5.087.687-.213.687-.476 0-.237-.013-1.024-.013-1.862-2.512.463-3.162-.612-3.362-1.175-.113-.287-.6-1.175-1.025-1.412-.35-.188-.85-.65-.013-.663.788-.013 1.35.725 1.538 1.025.9 1.512 2.337 1.087 2.912.825.088-.65.35-1.088.638-1.338-2.225-.25-4.55-1.112-4.55-4.937 0-1.088.387-1.987 1.025-2.688-.1-.25-.45-1.274.1-2.65 0 0 .837-.262 2.75 1.026a9.28 9.28 0 0 1 2.5-.338c.85 0 1.7.112 2.5.337 1.912-1.3 2.75-1.024 2.75-1.024.55 1.375.2 2.4.1 2.65.637.7 1.025 1.587 1.025 2.687 0 3.838-2.337 4.688-4.562 4.938.362.312.675.912.675 1.85 0 1.337-.013 2.412-.013 2.75 0 .262.188.574.688.474A10.017 10.017 0 0 0 20 10c0-5.525-4.475-10-10-10Z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span class="grow text-xxs md:text-xs font-bold text-center">GitHub</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('socialite.redirect', 'vkontakte')}}"
                               class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
                                <svg fill="#fff" class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                     style="enable-background:new 0 0 64 64;" version="1.1" viewBox="0 0 64 64"
                                     xml:space="preserve"><g id="guidlines"></g>
                                    <g id="FB"></g>
                                    <g id="ig"></g>
                                    <g id="yt"></g>
                                    <g id="twitter"></g>
                                    <g id="snapchat"></g>
                                    <g id="WA"></g>
                                    <g id="Pinterrest"></g>
                                    <g id="Layer_9"></g>
                                    <g id="Layer_10"></g>
                                    <g id="Layer_11">
                                        <path class="st13"
                                              d="M4,13.9c2.1,0,5.3,0,7.1,0c0.9,0,1.6,0.6,1.9,1.4c0.9,2.6,2.9,8.3,5.2,12.2c3.1,5.1,5.1,7,6.4,6.8   c1.3-0.3,0.9-3.7,0.9-6.4s0.3-7.3-1-9.4l-2-2.9c-0.5-0.7,0-1.6,0.8-1.6h11.4c1.1,0,2,0.9,2,2v14.5c0,0,0.5,2.6,3.3-0.1   c2.8-2.7,5.8-7.7,8.3-12.8l1-2.4c0.3-0.7,1-1.2,1.8-1.2h7.4c1.4,0,2.4,1.4,1.9,2.7l-0.8,2.1c0,0-2.7,5.4-5.5,9.2   c-2.8,3.9-3.4,4.8-3,5.8c0.4,1,7.6,7.7,9.4,10.9c0.5,0.9,0.9,1.7,1.3,2.4c0.7,1.3-0.3,3-1.8,3l-8.4,0c-0.7,0-1.4-0.4-1.7-1   l-0.8-1.3c0,0-5.1-6-8.2-7.9c-3.2-1.8-3.1,0.8-3.1,0.8v5.3c0,2.2-1.8,4-4,4h-2c0,0-11,0-19.8-13.1C5.1,26.7,2.8,20.1,2,16.3   C1.8,15.1,2.7,13.9,4,13.9z"></path>
                                    </g>
                                    <g id="Layer_12"></g>
                                    <g id="Layer_13"></g>
                                    <g id="Layer_14"></g>
                                    <g id="Layer_15"></g>
                                    <g id="Layer_16"></g>
                                    <g id="Layer_17"></g></svg>
                                <span class="grow text-xxs md:text-xs font-bold text-center">VK</span>
                            </a>
                        </li>
                    </ul>
                </x-slot:socialAuth>
                <x-slot:buttons>
                    <div class="space-y-3 mt-5">
                        <div class="text-xxs md:text-xs">Есть аккаунт?
                            <a href="{{route('login.page')}}"
                               class="text-white hover:text-white/70 font-bold underline underline-offset-4">Войти</a>
                        </div>
                    </div>
                </x-slot:buttons>
            </x-forms.auth-forms>
        </div>
    </main>

@endsection
