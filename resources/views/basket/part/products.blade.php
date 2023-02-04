@foreach($products as $product)
    <li class="cart__item cart-item" data-pid="{{ $product->id }}">
        <input type="hidden" id="2" name="id[]" value="2">
        <a href="#" class="cart-item__image">
            <img src="https://res.cloudinary.com/lmru/image/upload/dpr_2.0,f_auto,q_auto,w_240,h_240,c_pad,b_white,d_photoiscoming.png/LMCode/82325238.jpg" alt="">
        </a>
        <a href="" class="cart-item__name">{{ $product->name }}</a>
        <p class="cart-item__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>

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

        <p class="cart-item__full-price"><span>{{ $product->pivot->quantity * $product->price }}</span> <span>₽</span></p>

        <form action="{{ route('basket.remove', ['id' => $product->id])  }}" method="post">
            @csrf
            <button type="submit" class="cart-item__delete-btn">Удалить</button>
        </form>

    </li>
@endforeach
