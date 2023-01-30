@extends ('layout.site', ['title' => 'Корзина'])

@section('content')

    <form class="cart">
        <h2 class="cart__title">Корзина</h2>
        <ul class="cart__list">

            <input type="hidden" name="num[]" value="2">

            @foreach($products as $product)
                <li class="cart__item cart-item" data-pid="{{ $product->id }}">
                    <input type="hidden" id="2" name="id[]" value="2">
                    <a href="#" class="cart-item__image">
                        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
                    </a>
                    <a href="" class="cart-item__name">{{ $product->name }}</a>
                    <p class="cart-item__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>
                    <div class="cart-item__counter">
                        <button type="button" class="cart-item__minus-btn">-</button>
                        <input class="cart-item__input" type="number" value="{{ $product->pivot->quantity }}">
                        <button type="button" class="cart-item__plus-btn">+</button>
                    </div>
                    <p class="cart-item__full-price"><span>{{ $product->pivot->quantity * $product->price }}</span> <span>₽</span></p>
                    <button type="button" class="cart-item__delete-btn">Удалить</button>
                </li>
            @endforeach

        </ul>
        <div class="cart__result">
            <b class="cart__result-text">Итого:</b>
            <b class="cart__result-price">56000 ₽</b>
        </div>
        <div class="cart__form">
            <div class="form">
                <h2 class="cart__title">Введите данные для заказа</h2>
                <div class="form__item">
                    <label class="form__label">Имя<sup>*</sup></label>
                    <input type="text" class="form__input" name="username" data-required="" data-valid="true">
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
                    <input class="form__checkbox" type="checkbox" id="agreement">
                    <label for="agreement" class="form__agreement-text">Согласен на обработку</label>
                    <a href="agreement.html" class="form__agreement-link">персональных данных</a>
                </div>

                <button type="submit" class="form__buy-btn" disabled="">Оформить заказ</button>
            </div>
        </div>
    </form>

@endsection
