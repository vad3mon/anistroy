@extends('layout.site', ['title' => 'Главная'])

@section('content')

    <section class="lead">
        <div class="lead__swiper swiper">
            <div class="swiper-wrapper">
                @foreach($bannerProducts as $bannerProduct)
                    <div class="lead__slide swiper-slide">
                        <a class="lead__link" href="{{ route('catalog.product', ['category' => $bannerProduct->category->slug, 'product'=>$bannerProduct->slug]) }}"></a>
                        <div class="lead__image">
                            @if (file_exists('images/products/' . $bannerProduct->image) && $bannerProduct->image)
                                <img src="{{ asset('images/products/' . $bannerProduct->image) }}" alt="{{ $bannerProduct->name }}">
                            @else
                                <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $bannerProduct->name }}">
                            @endif
                        </div>
                        <div class="lead__info">
                            <h3 class="lead__name">
                                {{ $bannerProduct->name }} <br class="hide-on-mobile">
                            </h3>
                            <p class="lead__price">{{ $bannerProduct->price }} <span>₽ / {{ $bannerProduct->unit }}</span></p>
                            <a class="lead__more-btn" href="{{ route('catalog.product', ['category' => $bannerProduct->category->slug, 'product'=>$bannerProduct->slug]) }}">Подробнее</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="products">
            <h2 class="products__title">
                Товары со скидкой
            </h2>
            <div class="products__swiper swiper">
                <ul class="swiper-wrapper">

                    @foreach($discountProducts as $product)
                        <li class="card swiper-slide" data-pid="{{ $product->id }}" data-stock="100" data-img="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" data-price="{{ $product->price }}" data-title="{{ $product->name }}">
                            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="card__image">
                                @if (file_exists('images/products/' . $product->image) && $product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="card__name">{{ $product->name }}</a>
                            <div class="card__price-wrapper">
                                <p class="card__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>

                                @if($product->old_price > 0)
                                    <p class="card__price-old">{{ $product->old_price }} <span>₽ / {{ $product->unit }}</span></p>
                                @endif
                            </div>

                            <form action="{{ route('basket.add', ['id' => $product->id])  }}" method="post">
                                @csrf
                                <div class="card__counter-wrapper">
                                    <div class="card__counter">
                                        <button class="card__minus-btn" type="button">-</button>
                                        <input class="card__input" type="number" value="1" name="quantity">
                                        <button class="card__plus-btn" type="button">+</button>
                                    </div>

{{--                                    @if ($product->volume > 3)--}}
{{--                                        <p class="card__amount product__amount--green">В наличии</p>--}}
{{--                                        <!-- или -->--}}
{{--                                    @else--}}
{{--                                        <p class="card__amount product__amount--red">Осталось {{ $product->volume }} шт.</p>--}}
{{--                                    @endif--}}

                                </div>
                                <button class="card__cart-btn" title="Добавить в корзину" type="submit">В корзину</button>

                            </form>

                            <form action="{{ route('favorite.add', ['id' => $product->id])  }}" method="post">
                                @csrf
                               <button class="card__fav-btn" title="Добавить в избранное"></button>
                            </form>
                        </li>
                    @endforeach


                </ul>
                <button class="swiper-button-prev"></button>
                <button class="swiper-button-next"></button>
            </div>
        </div>
    </section>

@endsection
