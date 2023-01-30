@extends('layout.profile')

@section('content')
<section class="profile">
    <h2 class="profile__title">
        Смена пароля
    </h2>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="form">
            <div class="form__item">
                <label class="form__label">Текущий пароль<sup>*</sup></label>
                <div class="form__input-wrapper">
                    <input type="text" class="form__input form__input--icon" name="current_password" data-required>
                    <button type="button" class="form__eye-btn"></button>
                </div>
                <p class="form__error-text">{{ $errors->updatePassword->first('current_password') }}</p>
            </div>

            <div class="form__item">
                <label class="form__label">Новый пароль<sup>*</sup></label>
                <div class="form__input-wrapper">
                    <input type="password" class="form__input form__input--icon" name="password" data-required>
                    <button type="button" class="form__eye-btn"></button>
                </div>
                <p class="form__error-text">{{ $errors->updatePassword->first('password') }}</p>
            </div>

            <div class="form__item">
                <label class="form__label">Подтвердить пароль<sup>*</sup></label>
                <div class="form__input-wrapper">
                    <input type="password" class="form__input form__input--icon" name="password_confirmation" data-required>
                    <button type="button" class="form__eye-btn"></button>
                </div>
                <p class="form__error-text">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            </div>

            <div class="form__item">
                <button type="submit" class="form__save-btn">Сохранить</button>
            </div>

            <p class="profile__info">
                Если вы не помните текущий пароль, то вы можете изменить его, используя почту: <span class="form__link">mail@mail.ru</span>
            </p>

            <button type="submit" class="form__save-btn">Изменить пароль, используя почту</button>
        </div>
    </form>
</section>

@endsection
