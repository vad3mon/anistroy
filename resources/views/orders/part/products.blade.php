<ul class="buy__list">
    @foreach($products as $product)
        <li class="cart__item cart-item" data-pid="{{ $product->id }}">
            <a href="#" class="cart-item__image">
                <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
            </a>
            <a href="" class="cart-item__name">{{ $product->name }}</a>
            <p class="cart-item__price">{{ $product->price }} <span>₽ / {{ $product->product->unit }}</span></p>
            <p class="cart-item__amount">{{ $product->quantity }} <span>{{ $product->product->unit }}</span></p>
            <p class="cart-item__full-price"><span>{{ $product->price * $product->quantity }}</span> <span>₽</span></p>
        </li>
    @endforeach
</ul>
