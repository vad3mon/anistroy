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

        <form action="">
            <div class="form">
                <h2 class="form__title">Восстановление</h2>

                <div class="form__item">
                    <label class="form__label">Почта</label>
                    <input type="text" class="form__input" name="email">
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

                <button type="submit" class="form__auth-btn">Отправить</button>
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
