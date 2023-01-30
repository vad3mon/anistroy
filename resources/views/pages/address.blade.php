@extends('layout.profile', ['title' => 'Адреса доставки'])

@section('content')
    <section class="profile">
        <h2 class="profile__title">
            Адреса доставки
            <button class="profile__add-btn" data-open="add-address"></button>
        </h2>

        <section class="address">
            <table class="address__table">
                <tr class="address__item">
                    <td class="address__cell">Москва, ул. Крылатская, 28-1-45</td>
                    <td class="address__cell address__cell--right">
                        <button class="address__edit-btn" data-open="edit-address"></button>
                        <button class="address__delete-btn" data-open="delete-address"></button>
                    </td>
                </tr>

                <tr class="address__item">
                    <td class="address__cell">Москва, Красная площадь 1, кв. 15</td>
                    <td class="address__cell address__cell--right">
                        <button class="address__edit-btn" data-open="edit-address"></button>
                        <button class="address__delete-btn" data-open="delete-address"></button>
                    </td>
                </tr>

                <tr class="address__item">
                    <td class="address__cell">Москва, Котельники, ул. Сложеницина, д.25, кв. 15</td>
                    <td class="address__cell address__cell--right">
                        <button class="address__edit-btn" data-open="edit-address"></button>
                        <button class="address__delete-btn" data-open="delete-address"></button>
                    </td>
                </tr>
            </table>
        </section>
    </section>
@endsection
