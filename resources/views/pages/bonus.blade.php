@extends('layout.profile', ['title' => 'Адреса доставки'])

@section('content')

    <section class="profile">
        <h2 class="profile__title">
            Бонусная программа
        </h2>

        <div class="profile__info-wrapper">
            <div class="profile__info-box profile__info-box--wide">
                <span class="profile__label">Общая сумма оплаченных заказов: </span>
                <b class="profile__info">100 000 Р</b>
            </div>

            <div class="profile__info-box profile__info-box--wide">
                <span class="profile__label">Ваша скидка: </span>
                <b class="profile__info">10%</b>
            </div>
        </div>

        <h3 class="profile__subtitle">
            Наша бонусная система
        </h3>

        <p class="profile__text">У нас действует ступенчатая накопительная бонусная система, рассчитываемая в зависимости от суммы оплаченных заказов.</p>

        <section class="bonus">
            <table class="bonus__table">
                <tr class="bonus__header">
                    <th class="bonus__cell">Cумма оплаченных заказов</th>
                    <th class="bonus__cell">Cкидка</th>
                </tr>

                <tr class="bonus__item">
                    <td class="bonus__cell">0 - 200 000 Р</td>
                    <td class="bonus__cell">0%</td>
                </tr>

                <tr class="bonus__item">
                    <td class="bonus__cell">200 000 - 500 000 Р</td>
                    <td class="bonus__cell">5%</td>
                </tr>

                <tr class="bonus__item">
                    <td class="bonus__cell">500 000 - 1 000 000 Р</td>
                    <td class="bonus__cell">10%</td>
                </tr>
            </table>
        </section>
    </section>

@endsection
