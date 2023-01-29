@extends('layout.site', ['title' => $product->name])

@section('content')

    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a href="{{ route('index') }}" class="breadcrumbs__link">Главная</a></li>

        @foreach($parentCategories as $parentCategory)
            <li class="breadcrumbs__item"><a href="{{ route('catalog.category', ['category' => $parentCategory]) }}" class="breadcrumbs__link">{{ $parentCategory->name }}</a></li>
        @endforeach

        <li class="breadcrumbs__item"><span class="breadcrumbs__current">{{ $product->name }}</span></li>
    </ul>

    <section class="product" data-pid="{{ $product->id }}" data-stock="{{ $product->volume }}" data-img="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" data-price="{{ $product->price }}" data-title="{{ $product->name }}">
        <div class="product__info-box">
            <p class="product__art">Артикул: {{ $product->article }}</p>
            <h2 class="product__title">
                {{ $product->name }}
            </h2>
            <div class="product__sell-box">
                <div class="product__price-wrapper">
                    <p class="product__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>
                    <p class="product__price-old">{{ $product->old_price }} <span>₽ / {{ $product->unit }}</span></p>
                </div>

                <form action="{{ route('basket.add', ['id' => $product->id])  }}" method="post">
                    @csrf
                    <div class="product__counter-wrapper">
                        <div class="product__counter">
                            <button type="button" class="product__minus-btn">-</button>
                            <input class="product__input" type="number" value="1" name="quantity">
                            <button type="button" class="product__plus-btn">+</button>
                        </div>

                        @if ($product->volume > 3)
                        <p class="product__amount product__amount--green">В наличии</p>
                        <!-- или -->
                        @else
                            <p class="product__amount product__amount--red">Осталось 3 шт.</p>

                        @endif
                    </div>

                    <div class="product__button-box">
                        <button class="product__cart-btn" type="submit">В корзину</button>
                        <button class="product__fav-btn">В избранное</button>
                    </div>
                </form>

                <div class="delivery">
                    <p class="delivery__item">
                      <span class="delivery__key">Доставка
                        <b class="delivery__date">12 апреля</b>
                      </span>
                        <b class="delivery__value">от 450 ₽</b>
                    </p>
                    <p class="delivery__item">
                      <span class="delivery__key">Самовывоз
                        <b class="delivery__date">10 апреля</b>
                      </span>
                        <b class="delivery__value">бесплатно</b>
                    </p>
                </div>
            </div>
        </div>

        <div class="product__image">
            <div class="swiper product__slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82038772_01.jpg">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82038772.jpg">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82038772_02.jpg">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82038772_05.jpg">
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <section class="product__anchor anchor">
        <a class="anchor__item anchor__item--active" href="#description">Описание</a>
        <a class="anchor__item" href="#about">Характеристики</a>
        <a class="anchor__item" href="#similar">Похожие товары</a>
    </section>

    <section class="product-info">
        <div class="product-info__block" id="description">
            <h2 class="product-info__title">Описание</h2>
            <p class="product-info__description">{{ $product->text }}</p>

            <a class="product-info__link" href="https://res.cloudinary.com/lmru/image/upload/v1575382563/LMCode/82038772_ins.pdf" target="_blank">
                Инструкция для {{ $product->name }}
            </a>
        </div>

        <div class="product-info__block" id="about">
            <h2 class="product-info__title">Характеристики</h2>

            <div class="product-table">
                <p class="product-table__item">
                    <span class="product-table__key">Страна</span>
                    <span class="product-table__value">Китай</span>
                </p>

                <p class="product-table__item">
                    <span class="product-table__key">Гарантия</span>
                    <span class="product-table__value">2 года</span>
                </p>

                <p class="product-table__item">
                    <span class="product-table__key">Мощность (Вт)</span>
                    <span class="product-table__value">1700.0</span>
                </p>

                <p class="product-table__item">
                    <span class="product-table__key">Мощность (Вт)</span>
                    <span class="product-table__value">1700.0</span>
                </p>

                <p class="product-table__item">
                    <span class="product-table__key">Мощность (Вт)</span>
                    <span class="product-table__value">1700.0</span>
                </p>

                <p class="product-table__item">
                    <span class="product-table__key">Мощность (Вт)</span>
                    <span class="product-table__value">1700.0</span>
                </p>
            </div>
        </div>
    </section>

    <div class="products" id="similar">
        <h2 class="products__title">
            Похожие товары
        </h2>
        <div class="products__swiper swiper">
            <ul class="swiper-wrapper">

                @if($parentCategory->products)
                    @foreach($parentCategory->products as $similarProduct)

                        @if($similarProduct->id !== $product->id)
                            <li class="card swiper-slide" data-pid="{{ $similarProduct->id }}" data-stock="{{ $similarProduct->volume }}" data-img="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" data-price="{{ $similarProduct->price }}" data-title="{{ $similarProduct->name }}">
                                <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__image">
                                    <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
                                </a>
                                <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__name">{{ $similarProduct->name }}</a>
                                <div class="card__price-wrapper">
                                    <p class="card__price">{{ $similarProduct->price }} <span>₽ / {{ $similarProduct->unit }}</span></p>
                                    <p class="card__price-old">{{ $similarProduct->old_price }} <span>₽ / {{ $similarProduct->unit }}</span></p>
                                </div>
                                <form action="">
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
                                </form>
                            </li>
                        @endif

                    @endforeach
                @endif



            </ul>
            <button class="swiper-button-prev"></button>
            <button class="swiper-button-next"></button>
        </div>
    </div>

@endsection
