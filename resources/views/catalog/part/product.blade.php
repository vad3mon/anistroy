<li class="card" data-pid="{{ $product->id }}" data-stock="{{ $product->volume }}" data-img="{{ $product->image }}" data-price="{{ $product->price }}" data-title="{{ $product->name }}">
    <a href="{{ route('catalog.product', ['category' => $currentCategory->slug, 'product'=>$product->slug]) }}" class="card__image">
        <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
    </a>
    <a href="{{ route('catalog.product', ['category' => $currentCategory->slug, 'product'=>$product->slug]) }}" class="card__name">{{ $product->name }}</a>
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

            @if ($product->volume > 3)
                <p class="card__amount product__amount--green">В наличии</p>
                <!-- или -->
            @else
                <p class="card__amount product__amount--red">Осталось {{ $product->volume }} шт.</p>
            @endif

        </div>
        <button class="card__cart-btn" title="Добавить в корзину" type="submit">В корзину</button>

    </form>
    <button class="card__fav-btn" title="Добавить в избранное"></button>
</li>
