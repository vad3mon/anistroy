@extends("layout.profile", ['title' => "Заказ №" . "$order->id"])


@section("content")
    <section class="profile">
        <h2 class="profile__title">
            Заказ №{{ $order->id }}
        </h2>

        <div class="profile__info-wrapper">
            <div class="profile__info-box">
                <h4 class="profile__label">Дата</h4>
                <p class="profile__info">{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d.m.Y') }}</p>
            </div>

            <div class="profile__info-box">
                <h4 class="profile__label">Статус</h4>
                <p class="profile__info">{{ $order->status }}</p>
            </div>

            <div class="profile__info-box">
                <h4 class="profile__label">Статус оплаты</h4>
                <p class="profile__info">{{ $order->payment_status }}</p>
            </div>

            <div class="profile__info-box profile__info-box--wide">
                <h4 class="profile__label">Имя</h4>
                <p class="profile__info">{{ $order->name }}</p>
            </div>

            <div class="profile__info-box profile__info-box--wide">
                <h4 class="profile__label">Телефон</h4>
                <p class="profile__info">{{ $order->phone }}</p>
            </div>

            <div class="profile__info-box profile__info-box--wide">
                <h4 class="profile__label">Электронная почта</h4>
                <p class="profile__info">{{ $order->email }}</p>
            </div>

            <div class="profile__info-box profile__info-box--wide">
                <h4 class="profile__label">Комментарий</h4>
                <p class="profile__info">{{ $order->comment }}</p>
            </div>
        </div>

        <h3 class="profile__subtitle">
            Состав заказа
        </h3>

        <section class="buy">
            @include('orders.part.products', ['items' => $order->items])
            <div class="buy__result">
                <b class="buy__result-text">К оплате:</b>
                <b class="buy__result-price">{{ $order->amount }} ₽</b>
            </div>
        </section>
    </section>
@endsection
