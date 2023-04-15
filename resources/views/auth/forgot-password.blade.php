<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Восстановление пароля</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/index.8ff14a9889db2a568ce7.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.77893fdbf14175a4d1ad.css') }}">
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
<script src="{{ asset('js/auth.f6bba4a20c4ae77f807e.js') }}"></script>
<script src="{{ asset('js/validate.7d8d21e0792b4b716efd.js') }}"></script>
<script src="{{ asset('js/catalog-and-spoiler.5b93e478149cef6b08ba.js') }}"></script>
<script src="{{ asset('js/header.725bb8121f6d16923273.js') }}"></script>
<script src="{{ asset('js/modal.c4556f2eebbfb77e49c4.js') }}"></script>
<script src="{{ asset('js/product-item.822b961ebf917d00668a.js') }}"></script>
<script src="{{ asset('js/54.d0fa7b73b5a57e677cd9.js') }}"></script>
<script src="{{ asset('js/slider.4e43f9d3b8ed5d964970.js') }}"></script>
<script src="{{ asset('js/cookie.cdb72658b07995caf8c5.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.57815a8e958fb878b943.js') }}"></script>
<script src="{{ asset('js/index.1777611d218d1a8828b2.js') }}"></script>
</html>
