@extends ('layout.site', ['title' => 'Корзина'])

@section('content')

{{--    <form class="cart">--}}
        <h2 class="cart__title">Корзина</h2>
        <ul class="cart__list">

            <input type="hidden" name="num[]" value="2">

            @include('basket.part.products', ['products' => $products])

        </ul>
        <div class="cart__result">
            @if ($amount > 0)
                <b class="cart__result-text">Итого:</b>
                <b class="cart__result-price">{{ $amount }} ₽</b>

            @else
                Ваша корзина пуста. Перейти в <a href="{{ route('index') }}">каталог</a>
            @endif

        </div>
        <div class="cart__form">
            <div class="form">
                <form action="{{ route('basket.saveorder')  }}" method="post">
                    @csrf
                    <h2 class="cart__title">Введите данные для заказа</h2>
                    <div class="form__item">
                        <label class="form__label">Имя<sup>*</sup></label>
                        <input type="text" class="form__input" name="name" data-required="" data-valid="true">
                        <p class="form__error-text"></p>
                    </div>

                    <div class="form__item">
                        <label class="form__label">Почта</label>
                        <input type="text" class="form__input" name="email" data-valid="true">
                        <p class="form__error-text"></p>
                    </div>

                    <div class="form__item">
                        <label class="form__label">Телефон<sup>*</sup></label>
                        <input type="text" class="form__input" name="phone" data-required="" data-valid="true">
                        <p class="form__error-text"></p>
                    </div>

                    <div class="form__item">
                        <label class="form__label">Адрес доставки</label>
                        <input type="text" class="form__input" name="address" data-valid="true">
                        <p class="form__error-text"></p>
                    </div>

                    <div class="form__agreement">
                        <input class="form__checkbox" type="checkbox" id="agreement" name="agreement">
                        <label for="agreement" class="form__agreement-text">Согласен на обработку</label>
                        <a href="{{ route('agreement') }}" class="form__agreement-link">персональных данных</a>
                    </div>

                    <button type="submit" class="form__buy-btn" disabled="">Оформить заказ</button>
                </form>
            </div>
        </div>
{{--    </form>--}}
@endsection

