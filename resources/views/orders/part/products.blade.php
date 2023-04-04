<ul class="buy__list">
    @foreach($items as $item)
        <li class="cart__item cart-item" data-pid="{{ $item->product->id }}">
            <a href="{{ route('catalog.product', ['category' => $item->product->category->slug, 'product'=>$item->product->slug]) }}" class="cart-item__image">
                @if (file_exists('images/products/' . $item->product->image) && $item->product->image)
                    <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                @else
                    <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $item->product->name }}">
                @endif
            </a>
            <a href="{{ route('catalog.product', ['category' => $item->product->category->slug, 'product'=>$item->product->slug]) }}" class="cart-item__name">{{ $item->product->name }}</a>
            <p class="cart-item__price">{{ $item->price }} <span>₽ / {{ $item->product->unit }}</span></p>
            <p class="cart-item__amount">{{ $item->quantity }} <span>{{ $item->product->unit }}</span></p>
            <p class="cart-item__full-price"><span>{{ $item->price * $item->quantity }}</span> <span>₽</span></p>
        </li>
    @endforeach
</ul>
