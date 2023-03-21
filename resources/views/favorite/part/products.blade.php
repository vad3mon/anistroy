<ul class="fav__list">
    @foreach($products as $product)
        <li class="fav__item fav-item" data-pid="{{ $product->id }}">
            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="fav-item__image">
                <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
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
