{{--@php dd(session()->get('favorite')) @endphp--}}
<li class="card" data-pid="{{ $product->id }}" data-stock="100" data-img="{{ $product->image }}" data-price="{{ $product->price }}" data-title="{{ $product->name }}">
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

{{--            @if ($product->volume > 3)--}}
{{--                <p class="card__amount product__amount--green">В наличии</p>--}}
{{--                <!-- или -->--}}
{{--            @else--}}
{{--                <p class="card__amount product__amount--red">Осталось {{ $product->volume }} шт.</p>--}}
{{--            @endif--}}

        </div>
        @if (session()->get('inCart') && session()->get('inCart')->contains($product->id))
            <button class="card__cart-btn active" title="Перейти в корзину" type="submit">В корзине</button>
        @else
            <button class="card__cart-btn" title="Добавить в корзину" type="submit">В корзину</button>
        @endif
    </form>

    <form action="{{ route('favorite.add', ['id' => $product->id])  }}" method="post">
        @csrf
        @if (session()->get('inFav') && session()->get('inFav')->contains($product->id))
            <button class="card__fav-btn active" title="Удалить из избранного"></button>
        @else
            <button class="card__fav-btn" title="Добавить в избранное"></button>
        @endif
    </form>
</li>
