<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Авторизация</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    @include('layout.part.css')
</head>

<body>
@include('layout.part.header')
<div class="login">
    <section class="login__form form">
        <a class="login__logo" href="{{ route('index') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo">
        </a>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form">
                <h2 class="form__title">Авторизация</h2>
                <div class="form__item">
                    <label class="form__label" for="phone">Телефон или email<sup>*</sup></label>
                    <input type="text" class="form__input" name="login" id="login" data-required value="{{ old('login') ?? '' }}">
                    <p class="form__error-text">{{ $errors->first('login') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Пароль<sup>*</sup></label>
                    <input type="password" class="form__input form__input--icon" name="password" id="password" data-required>
                    <p class="form__error-text">{{ $errors->first('password') }}</p>
                    <a class="form__link" href="{{ route('password.request') }}">Забыли пароль?</a>
                </div>

                <button type="submit" class="form__auth-btn">Авторизация</button>

                <p class="form__text">
                    Еще нет аккаунта?
                    <a class="form__link" href="{{ route('register') }}">Зарегистрироваться</a>
                </p>
            </div>
        </form>
    </section>
</div>
</body>
<section class="cookie">
    <p>Оставаясь на нашем сайте, вы соглашаетесь с нашей <a class="cookie__link" href="{{ route('pages.index', ['page' => 'politika-obrabotki-personalnyh-dannyh']) }}"> политикой обработки персональных данных и использования кукис </a></p>
    <button class="cookie__save-btn">Соглашаюсь</button>
</section>
@include('layout.part.js')
</html>
