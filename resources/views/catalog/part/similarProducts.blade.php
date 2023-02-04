@foreach($parentCategory->products as $similarProduct)

    @if($similarProduct->id !== $product->id)
        @include('catalog.part.product', ['product' => $similarProduct, 'currentCategory' => $parentCategory])
{{--        <li class="card swiper-slide" data-pid="{{ $similarProduct->id }}" data-stock="{{ $similarProduct->volume }}" data-img="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" data-price="{{ $similarProduct->price }}" data-title="{{ $similarProduct->name }}">--}}
{{--            <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__image">--}}
{{--                <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">--}}
{{--            </a>--}}
{{--            <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__name">{{ $similarProduct->name }}</a>--}}
{{--            <div class="card__price-wrapper">--}}
{{--                <p class="card__price">{{ $similarProduct->price }} <span>₽ / {{ $similarProduct->unit }}</span></p>--}}
{{--                <p class="card__price-old">{{ $similarProduct->old_price }} <span>₽ / {{ $similarProduct->unit }}</span></p>--}}
{{--            </div>--}}
{{--            <form action="">--}}
{{--                <div class="card__counter-wrapper">--}}
{{--                    <div class="card__counter">--}}
{{--                        <button class="card__minus-btn">-</button>--}}
{{--                        <input class="card__input" type="number" value="1">--}}
{{--                        <button class="card__plus-btn">+</button>--}}
{{--                    </div>--}}
{{--                    <p class="card__amount">В наличии</p>--}}
{{--                </div>--}}
{{--                <button class="card__cart-btn" title="Добавить в корзину">В корзину</button>--}}
{{--                <button class="card__fav-btn" title="Добавить в избранное"></button>--}}
{{--            </form>--}}
{{--        </li>--}}
    @endif

@endforeach
