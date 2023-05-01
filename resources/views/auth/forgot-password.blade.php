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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form">
                <h2 class="form__title">Восстановление</h2>

                <div class="form__item">
                    <label class="form__label">Почта</label>
                    <input type="text" class="form__input" name="email" value="{{ old('email') }}">
                    <p class="form__error-text">{{ $errors->first('email') }}</p>
                </div>

                <button type="submit" class="form__auth-btn">Отправить</button>
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
