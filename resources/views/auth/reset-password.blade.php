<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Восстановление пароля</title>
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

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form">
                <h2 class="form__title">Восстановление</h2>

                <div class="form__item">
                    <label class="form__label">Почта <sup>*</sup></label>
                    <input type="text" class="form__input" name="email" value="{{ $request->email }}" data-required>
                    <p class="form__error-text">{{ $errors->first('email') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Новый пароль<sup>*</sup></label>
                    <div class="form__input-wrapper">
                        <input type="password" class="form__input form__input--icon" name="password" data-required>
                        <button type="button" class="form__eye-btn"></button>
                    </div>
                    <p class="form__error-text">{{ $errors->first('password') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Подтвердить пароль<sup>*</sup></label>
                    <div class="form__input-wrapper">
                        <input type="password" class="form__input form__input--icon" name="password_confirmation" data-required>
                        <button type="button" class="form__eye-btn"></button>
                    </div>
                    <p class="form__error-text">{{ $errors->first('password_confirmation') }}</p>
                </div>

                <button type="submit" class="form__btn form__auth-btn" disabled="disabled">Отправить</button>
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
