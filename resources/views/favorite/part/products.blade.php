<ul class="fav__list">
    @foreach($products as $product)
        <li class="fav__item fav-item" data-pid="{{ $product->id }}">
            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="fav-item__image">
                @if (file_exists('images/products/' . $product->image) && $product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $product->name }}">
                @endif
            </a>
            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="fav-item__name">{{ $product->name }}</a>
            <p class="fav-item__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>

            <form action="{{ route('basket.add', ['id' => $product->id])  }}" method="post">
                @csrf
                <button class="fav-item__cart-btn active" type="submit">В корзину</button>
            </form>


            <form action="{{ route('favorite.remove', ['id' => $product->id])  }}" method="post">
                @csrf
                <button type="submit" class="fav-item__delete-btn">Удалить</button>
            </form>
        </li>
    @endforeach

</ul>
