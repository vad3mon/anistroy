@extends('layout.site')

@section('content')

<section class="all-products products">
    <h2 class="products__title">{{ $category->name }}</h2>

    <ul class="products__list">
        @foreach($products as $product)
            <li class="card" data-pid="{{ $product->id }}" data-stock="{{ $product->volume }}" data-img="{{ $product->image }}" data-price="{{ $product->price }}" data-title="{{ $product->name }}">
                <a href="#" class="card__image">
                    <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
                </a>
                <a href="" class="card__name">{{ $product->name }}</a>
                <div class="card__price-wrapper">
                    <p class="card__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>
                    <p class="card__price-old">{{ $product->old_price }} <span>₽ / {{ $product->unit }}</span></p>
                </div>
                <div class="card__counter-wrapper">
                    <div class="card__counter">
                        <button class="card__minus-btn">-</button>
                        <input class="card__input" type="number" value="1">
                        <button class="card__plus-btn">+</button>
                    </div>
                    <p class="card__amount">В наличии</p>
                </div>
                <button class="card__cart-btn" title="Добавить в корзину">В корзину</button>
                <button class="card__fav-btn" title="Добавить в избранное"></button>
            </li>
        @endforeach
    </ul>


    <div class="pagination">

        {{--                    <a class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled" href="#">Предыдущая страница</a>--}}
        {{--                    <span class="pagination__button pagination__button--active">1</span>--}}
        {{--                    <a class="pagination__button" href="#">2</a>--}}
        {{--                    <a class="pagination__button" href="#">3</a>--}}
        {{--                    <a class="pagination__arrow pagination__arrow--next" href="#">Следующая страница</a>--}}
    </div>
</section>

@endsection
