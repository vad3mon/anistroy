@extends("layout.profile")

@section("content")
    <section class="profile">
        <h2 class="profile__title">
            Мои данные
        </h2>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <div class="form">
                <div class="form__item">
                    <label class="form__label">Имя<sup>*</sup></label>
                    <input type="text" class="form__input" name="name" value="{{ auth()->user()->name }}" data-required>
                    <p class="form__error-text">{{ $errors->first('name') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Почта</label>
                    <input type="text" class="form__input" name="email" value="{{ auth()->user()->email }}">
                    <p class="form__error-text">{{ $errors->first('email') }}</p>
                </div>

                <div class="form__item">
                    <label class="form__label">Телефон<sup>*</sup></label>
                    <input type="text" class="form__input" name="phone" value="{{ auth()->user()->phone }}" data-required>
                    <p class="form__error-text">{{ $errors->first('phone') }}</p>
                </div>

                <button type="submit" class="form__save-btn">Сохранить</button>
            </div>
        </form>
    </section>
@endsection

