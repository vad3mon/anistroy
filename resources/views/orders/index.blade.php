@extends("layout.profile")

@section("content")
    <section class="profile">
        <h2 class="profile__title">
            Мои заказы
        </h2>

        <section class="order">
            <table class="order__table">
                <tr class="order__header">
                    <th class="order__cell">Номер заказа</th>
                    <th class="order__cell">Дата</th>
                    <th class="order__cell">Состав</th>
                    <th class="order__cell">Статус</th>
                    <th class="order__cell">Статус оплаты</th>
                </tr>

                @foreach($orders as $order)

                        <tr class="order__item">
                                <td class="order__cell">

                                        {{ $order->id }}

                                </td>
                                <td class="order__cell">{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d.m.Y') }}</td>
                                <td class="order__cell">
                                    <p>{{ $order->items->count() }} товаров</p>
                                    <p>{{ $order->amount }} Р</p>
                                </td>
                                <td class="order__cell">{{ $order->status }}</td>
                                <td class="order__cell order__cell--accept">{{ $order->payment_status }}</td>
                        </tr>

                @endforeach


            </table>
        </section>
    </section>
@endsection
