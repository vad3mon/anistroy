<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Document</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/index.a7f4569d5dc6e8b680aa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.77893fdbf14175a4d1ad.css') }}">
</head>
<body>
<div class="login">
    <section class="login__form form">
        <a class="login__logo" href="{{ route('index') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo">
        </a>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form">
                <h2 class="form__title">Регистрация</h2>
                <div class="form__item">
                    <label class="form__label" for="name">Имя<sup>*</sup></label>
                    <input type="text" class="form__input" name="name" id="name" data-required value="{{ old('name') ?? '' }}">
                    <p class="form__error-text">{{ $errors->first('name') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label" for="email">Почта</label>
                    <input type="text" class="form__input" name="email" id="email" {{ old('email') ?? '' }}>
                    <p class="form__error-text">{{ $errors->first('email') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label" for="phone">Телефон<sup>*</sup></label>
                    <input type="text" class="form__input" name="phone" id="phone" data-required {{ old('phone') ?? '' }}>
                    <p class="form__error-text">{{ $errors->first('phone') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label" for="password">Пароль<sup>*</sup></label>
                    <div class="form__input-wrapper">
                        <input type="password" class="form__input form__input--icon" name="password" id="password" data-required>
                        <button type="button" class="form__eye-btn"></button>
                    </div>
                    <p class="form__error-text">{{ $errors->first('password') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label" for="password_confirmation">Подтвердить пароль<sup>*</sup></label>
                    <div class="form__input-wrapper">
                        <input type="password" class="form__input form__input--icon" name="password_confirmation" id="password_confirmation" data-required>
                        <button type="button" class="form__eye-btn"></button>
                    </div>
                    <p class="form__error-text">{{ $errors->first('password_confirmation') }}</p>
                </div>

                <div class="form__agreement">
                    <input class="form__checkbox" type="checkbox" id="agreement" name="agreement" data-required>
                    <label for="agreement" class="form__agreement-text">Согласен на обработку</label>
                    <a href="agreement.html" class="form__agreement-link">персональных данных</a>
                    <p class="form__error-text">{{ $errors->first('agreement') }}</p>
                </div>

                <button type="submit" class="form__auth-btn">Регистрация</button>

                <p class="form__text">
                    Есть аккаунт?
                    <a class="form__link" href="{{ route('login') }}">Войти</a>
                </p>
            </div>
        </form>
    </section>
</div>
</body>
<script src="{{ asset('js/header.247d4f67111134fa93dd.js') }}"></script>
<script src="{{asset('js/54.d0fa7b73b5a57e677cd9.js')}}"></script>
<script src="{{ asset('js/slider.4e43f9d3b8ed5d964970.js') }}"></script>
<script src="{{ asset('js/catalog-and-spoiler.72132c7401a28c7a9e7b.js') }}"></script>
<script src="{{ asset('js/imask.93caf3dc1c70c1a43a6d.js') }}"></script>
<script src="{{ asset('js/product-item.3c3baec3d647db3cf99f.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.57815a8e958fb878b943.js') }}"></script>
<script src="{{ asset('js/cart-form.634482d529a016264323.js') }}"></script>
<script src="{{ asset('js/auth.f6bba4a20c4ae77f807e.js') }}"></script>
<script src="{{ asset('js/modal.c4556f2eebbfb77e49c4.js') }}"></script>
<script src="{{ asset('js/index.e7bf726abb530d2c0754.js') }}"></script>
</html>

{{--<x-guest-layout>--}}
{{--    <form method="POST" action="{{ route('register') }}">--}}
{{--        @csrf--}}

{{--        <!-- Name -->--}}
{{--        <div>--}}
{{--            <x-input-label for="name" :value="__('Name')" />--}}
{{--            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />--}}
{{--            <x-input-error :messages="$errors->get('name')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Email Address -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="new-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Confirm Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--            <x-text-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password_confirmation" required />--}}

{{--            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">--}}
{{--                {{ __('Already registered?') }}--}}
{{--            </a>--}}

{{--            <x-primary-button class="ml-4">--}}
{{--                {{ __('Register') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}
