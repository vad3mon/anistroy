@foreach($products as $product)
    <li class="cart__item cart-item" data-pid="{{ $product->id }}">
        <input type="hidden" id="2" name="id[]" value="2">
        <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="cart-item__image">
            @if (file_exists('images/products/' . $product->image) && $product->image)
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $product->name }}">
            @endif
        </a>
        <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="cart-item__name">{{ $product->name }}</a>

        @if($product->price > 0)
            <p class="cart-item__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>
        @else
            <p class="cart-item__price">Под заказ</p>
        @endif

        <div class="cart-item__counter">

            <form action="{{ route('basket.minus', ['id' => $product->id])  }}" method="post">
                @csrf
                <button type="submit" class="cart-item__minus-btn">-</button>
            </form>

            <input class="cart-item__input" type="number" value="{{ $product->pivot->quantity }}" name="quantity">

            <form action="{{ route('basket.plus', ['id' => $product->id])  }}" method="post">
                @csrf
                <button type="submit" class="cart-item__plus-btn">+</button>
            </form>
        </div>


        @if($product->price > 0)
            <p class="cart-item__full-price"><span>{{ $product->pivot->quantity * $product->price }}</span> <span>₽</span></p>
        @else
            <p class="cart-item__full-price">Под заказ</p>
        @endif


        <form action="{{ route('basket.remove', ['id' => $product->id])  }}" method="post">
            @csrf
            <button type="submit" class="cart-item__delete-btn">Удалить</button>
        </form>

    </li>
@endforeach
