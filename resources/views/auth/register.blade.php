<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Регистрация</title>
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
                    <input type="text" class="form__input" name="email" id="email" data-required value="{{ old('email') ?? '' }}">
                    <p class="form__error-text">{{ $errors->first('email') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Телефон<sup>*</sup></label>
                    <input type="text" class="form__input" name="phone" id="phone" data-required value="{{ old('email') ?? '' }}">
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
                    <input class="form__checkbox" type="checkbox" id="agreement" name="checkbox" data-required>
                    <label for="agreement" class="form__agreement-text">Согласен на обработку</label>
                    <a href="{{ route('pages.index', ['page' => 'agreement']) }}" class="form__agreement-link">персональных данных</a>
                    <p class="form__error-text">{{ $errors->first('agreement') }}</p>
                </div>

                <button type="submit" class="form__btn form__auth-btn" disabled="disabled">Регистрация</button>

                <p class="form__text">
                    Есть аккаунт?
                    <a class="form__link" href="{{ route('login') }}">Войти</a>
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
