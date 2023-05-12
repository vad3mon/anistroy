@foreach($parentCategory->products as $similarProduct)

    @if($similarProduct->id !== $product->id)
        <li class="card swiper-slide" data-pid="{{ $similarProduct->id }}" data-stock="10000000" data-img="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" data-price="{{ $similarProduct->price }}" data-title="{{ $similarProduct->name }}">
            <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__image">
                @if (file_exists('images/products/' . $similarProduct->image) && $similarProduct->image)
                    <img src="{{ asset('images/products/' . $similarProduct->image) }}" alt="{{ $similarProduct->name }}">
                @else
                    <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $similarProduct->name }}">
                @endif
            </a>
            <a href="{{ route('catalog.product', ['category' => $parentCategory->slug, 'product'=>$similarProduct->slug]) }}" class="card__name">{{ $similarProduct->name }}</a>
            <div class="card__price-wrapper">

                @if($product->price > 0)
                    <p class="card__price">{{ $similarProduct->price }} <span>₽ / {{ $similarProduct->unit }}</span></p>
                @else
                    <p class="card__price">Под заказ</p>
                @endif

                @if($similarProduct->old_price > 0)
                    <p class="card__price-old">{{ $similarProduct->old_price }} <span>₽ / {{ $similarProduct->unit }}</span></p>
                @endif
            </div>

            <form action="{{ route('basket.add', ['id' => $similarProduct->id])  }}" method="post">
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

                @if (session()->get('inCart') && session()->get('inCart')->contains($similarProduct->id))
                    <button class="card__cart-btn active" title="Перейти в корзину" type="submit">В корзине</button>
                @else
                    <button class="card__cart-btn" title="Добавить в корзину" type="submit">В корзину</button>
                @endif

            </form>

            <form action="{{ route('favorite.add', ['id' => $similarProduct->id])  }}" method="post">
                @csrf
                @if (session()->get('inFav') && session()->get('inFav')->contains($similarProduct->id))
                    <button class="card__fav-btn active" title="Удалить из избранного"></button>
                @else
                    <button class="card__fav-btn" title="Добавить в избранное"></button>
                @endif
            </form>
        </li>
    @endif

@endforeach
