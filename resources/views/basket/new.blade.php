<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Корзина</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">

    <script src="https://api-maps.yandex.ru/2.1/?apikey=5ece939f-3dc7-4de4-ae0e-9f37dbe7edba&lang=ru_RU" type="text/javascript"></script>


    @include('layout.part.css')
</head>

<body>
<div class="site-wrapper">
    @include('layout.part.header')
    <main class="main">
        <div class="main__container container">
            <div class="content">
                <form class="form new-order" action="" method="post" id="orderForm">
                    @csrf
                    <div>
                        <h2 class="new-order__title">Ваш заказ</h2>
                        <section class="new-order__item new-order__item--available">
                            <h3 class="new-order__subtitle">В наличии</h3>
                            <ul class="new-order__list">
                                @foreach($products->where('price', '>', 0) as $product)
                                    @if($product->price)
                                        <li class="new-order__product" data-pid="{{ $product['id'] }}">
                                            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="new-order__image">
                                                @if (file_exists('images/products/' . $product->image) && $product->image)
                                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $product->name }}">
                                                @endif
                                            </a>

                                            <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="new-order__name">{{ $product->name }}</a>
                                            <p class="new-order__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>
                                            <p class="new-order__amount">{{ $product->pivot->quantity }} <span>{{ $product->unit }}</span></p>
                                            <p class="new-order__full-price"><span>{{ $product->pivot->quantity * $product->price }}</span>
                                                <span>₽</span></p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </section>

                        @if ($products->contains('price', 0))
                            <section class="new-order__item">
                                <h3 class="new-order__subtitle">Под заказ</h3>
                                <p>
                                    Товары не в наличии, будем заказывать под вас. Их доставка тоже
                                    считается отдельно
                                    нашим менеджером.
                                </p>
                                <ul class="new-order__list">
                                    @foreach($products->where('price', 0) as $product)
                                            <li class="new-order__product" data-pid="{{ $product['id'] }}">
                                                <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="new-order__image">
                                                    @if (file_exists('images/products/' . $product->image) && $product->image)
                                                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="{{ asset('images/products/images_empty.png') }}" alt="{{ $product->name }}">
                                                    @endif
                                                </a>

                                                <a href="{{ route('catalog.product', ['category' => $product->category->slug, 'product'=>$product->slug]) }}" class="new-order__name">{{ $product->name }}</a>
                                                {{--                                            <p class="new-order__price">{{ $product->price }} <span>₽ / {{ $product->unit }}</span></p>--}}
                                                <p class="new-order__price">Под заказ</p>
                                                <p class="new-order__amount">{{ $product->pivot->quantity }} <span>{{ $product->unit }}</span></p>
                                                <p class="new-order__full-price">Под заказ</p>
                                            </li>
                                    @endforeach

                                </ul>
                            </section>
                        @endif

                        <div class="new-order__result">
                            <b class="new-order__result-text">К оплате:</b>
                            <b class="new-order__result-price">{{ $amount }} ₽</b>
                        </div>

                        @if ($amount < 5000)
                            <section class="new-order__warning-box new-order__warning-box--error">
                                Мы работаем с заказами от <b>5000 рублей</b>.
                                Купите еще что-нибудь.
                            </section>
                        @endif

                        @if(!auth()->user())
                            <section class="new-order__warning-box">
                                <a class="new-order__link">Войдите</a> или <a class="new-order__link">зарегистрируйтесь</a>, чтобы
                                сохранить данные о заказе и участвовать в системе накопительных
                                скидок
                            </section>
                        @endif

                        <section class="new-order__step-list">
                            <div class="new-order__step">
                                <div class="new-order__step-header">
                                    <p class="new-order__step-counter">1</p>
                                    <h3 class="new-order__step-title">Данные заказчика<sup>*</sup>
                                    </h3>
                                </div>
                                <div class="new-order__gap js-form-item">
                                    <label class="label">Имя<sup>*</sup></label>
                                    <input type="text" class="js-input input" name="name" autocomplete="off">
                                    <p class="error-text js-error-text"></p>
                                </div>

                                <div class="new-order__gap js-form-item">
                                    <label class="label">Почта<sup>*</sup></label>
                                    <input type="text" class="input js-input" name="email" autocomplete="off">
                                    <p class="error-text js-error-text"></p>
                                </div>

                                <div class="new-order__gap js-form-item">
                                    <label class="label">Телефон<sup>*</sup></label>
                                    <input type="text" class="input js-input" name="phone" autocomplete="off">
                                    <p class="error-text js-error-text"></p>
                                </div>
                            </div>
                            <div class="new-order__tabs">
                                <button type="button" data-tab-btn="delivery" class="new-order__tab active">Доставка</button>
                                <button type="button" data-tab-btn="pickup" class="new-order__tab">Самовывоз</button>
                            </div>

                            <section data-tab="delivery" class="new-order__section active">

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">2</p>
                                        <h3 class="new-order__step-title">Адрес доставки<sup>*</sup>
                                        </h3>
                                    </div>
                                    <div class="new-order__gap js-form-item">
                                        <input id="stringAddress" type="text" class="js-input input" name="address" autocomplete="off" data-required>
                                        <p class="error-text js-error-text"></p>
                                    </div>

                                    <div class="new-order__map" id="new-order__map"></div>

                                    <section class="new-order__row">
                                        <div class="checkbox">
                                            <input class="checkbox__input" type="checkbox" id="1" name="heightRest">
                                            <label for="1" class="checkbox__label">
                                                Есть ограничения по высоте (арка, подземный паркинг)?
                                            </label>
                                        </div>

                                        <div class="new-order__input-wrapper">
                                            <input type="text" class="input input--small" autocomplete="off" placeholder="3м" name="heightRestValue">
                                            <label class="label">Укажите высоту арки,
                                                паркинга</label>
                                        </div>
                                    </section>

                                    <section>
                                        <label class="label">Мастер на этом адресе</label>

                                        <div class="new-order__row js-form-item">
                                            <input type="text" class="js-input input" placeholder="ФИО" name="masterName">
                                            <input type="text" class="js-input input" name="masterPhone" autocomplete="off">
                                        </div>
                                    </section>

                                    <div>
                                        <label class="label">Комментарий водителю</label>
                                        <textarea class="input" name="driverComment" autocomplete="off" rows="6"></textarea>
                                        <p class="error-text"></p>
                                    </div>
                                </section>

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">3</p>
                                        <h3 class="new-order__step-title">Желаемые дата и время
                                            доставки<sup>*</sup></h3>
                                    </div>
                                    <section>
                                        <label class="label">Дата</label>

                                        <div class="new-order__row calendar">
                                            <div class="input-date">
                                                <input type="text" class="input" name="range-start" placeholder="c" readonly="readonly">
                                            </div>
                                            <div class="input-date">
                                                <input type="text" class="input" name="range-end" placeholder="по" readonly="readonly">
                                            </div>
                                        </div>

                                        <label class="label">Время</label>
                                        <div class="checkbox-radio">
                                            <div>
                                                <input class="checkbox-radio__button" type="radio" name="time" id="radio6" value="1" checked="checked">
                                                <label class="checkbox-radio__label" for="radio6">c 9:00
                                                    до 15:00</label>
                                            </div>
                                            <div>
                                                <input class="checkbox-radio__button" type="radio" name="time" id="radio3" value="2">
                                                <label class="checkbox-radio__label" for="radio3">с
                                                    15:00 до 21:00</label>
                                            </div>
                                            <div>
                                                <input class="checkbox-radio__button" type="radio" name="time" id="radio4" value="3">
                                                <label class="checkbox-radio__label" for="radio4">с
                                                    21:00 до 9:00 (расчет через менеджера)</label>
                                            </div>
                                        </div>
                                    </section>
                                </section>

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">4</p>
                                        <h3 class="new-order__step-title">Дополнительные услуги</h3>
                                    </div>

                                    <div class="checkbox-spoiler" data-spoilers>
                                        <input class="checkbox-spoiler__checkbox" type="checkbox" id="lift" name="lift">
                                        <label class="checkbox-spoiler__label" for="lift" data-spoiler>Подъем на этаж</label>
                                        <div class="checkbox-spoiler__content">
                                            <div class="new-order__checkbox-radio checkbox-radio">
                                                <div>
                                                    <input class="checkbox-radio__button" type="radio" name="opt" id="radio-d1" value="1" checked="checked">
                                                    <label class="checkbox-radio__label" for="radio-d1">Пассажирский
                                                        лифт</label>
                                                </div>
                                                <div>
                                                    <input class="checkbox-radio__button" type="radio" name="opt" id="radio-d2" value="2">
                                                    <label class="checkbox-radio__label" for="radio-d2">Грузовой
                                                        лифт</label>
                                                </div>
                                            </div>

                                            <div class="new-order__row new-order__row--start">
                                                <div>
                                                    <label class="label">Номер этажа</label>
                                                    <input type="text" class="input input--small" name="floor" autocomplete="off">
                                                </div>
                                                <div class="new-order__checkbox checkbox">
                                                    <input class="checkbox__input" type="checkbox" id="2" name="techFloor">
                                                    <label for="2" class="checkbox__label" title="Информация о тех этаже">Технический этаж
                                                        (?)</label>
                                                </div>
                                            </div>

                                            <div class="new-order__gap">
                                                <div class="checkbox">
                                                    <input class="checkbox__input" type="checkbox" id="3" name="overCarry">
                                                    <label for="3" class="checkbox__label">Грузчикам нужно
                                                        донести заказ от машины до вас более 25
                                                        метров</label>
                                                </div>
                                            </div>

                                            <div class="new-order__gap">
                                                <div class="new-order__input-wrapper">
                                                    <input type="text" class="input input--small" autocomplete="off" placeholder="20м" name="overCarryValue">
                                                    <label class="label">Укажите примерное
                                                        расстояние</label>
                                                </div>
                                            </div>

                                            <div class="new-order__gap">
                                                <div class="checkbox">
                                                    <input class="checkbox__input" type="checkbox" id="4" name="cleaning">
                                                    <label for="4" class="checkbox__label">Понадобится
                                                        уборка</label>
                                                </div>
                                            </div>


                                            <a href="" class="new-order__link">Правила оказания
                                                услуг</a>
                                        </div>
                                    </div>

                                    <div class="checkbox-spoiler" data-spoilers>
                                        <input class="checkbox-spoiler__checkbox" type="checkbox" id="unload" name="unload">
                                        <label class="checkbox-spoiler__label" for="unload" data-spoiler>Разгрузка</label>
                                        <div class="checkbox-spoiler__content">
                                            <a href="" class="new-order__link">Правила оказания
                                                услуг</a>
                                        </div>
                                    </div>

                                    <div class="checkbox-spoiler" data-spoilers>
                                        <input class="checkbox-spoiler__checkbox" type="checkbox" id="manipulator" name="manipulator">
                                        <label class="checkbox-spoiler__label" for="manipulator" data-spoiler>Манипулятор</label>
                                        <div class="checkbox-spoiler__content">
                                            <a href="" class="new-order__link">Правила оказания
                                                услуг</a>
                                        </div>
                                    </div>
                                </section>

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">5</p>
                                        <h3 class="new-order__step-title">Способ оплаты<sup></sup>
                                        </h3>
                                    </div>
                                    <div class="checkbox-radio">
                                        <div>
                                            <input class="checkbox-radio__button" type="radio" name="pay" id="radio1" value="Картой на сайте" checked="checked">
                                            <label class="checkbox-radio__label" for="radio1">Картой
                                                на сайте</label>
                                        </div>
                                        <div>
                                            <input class="checkbox-radio__button" type="radio" name="pay" id="radio2" value="Безналичным платежом">
                                            <label class="checkbox-radio__label" for="radio2">Безналичным
                                                платежом</label>
                                        </div>
                                    </div>
                                </section>

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">6</p>
                                        <h3 class="new-order__step-title">Комментарий к
                                            заказу<sup></sup></h3>
                                    </div>
                                    <textarea class="input" name="comment" autocomplete="off" rows="6"></textarea>
                                </section>
                            </section>
                            <section data-tab="pickup" class="new-order__section">

                                <section class="new-order__step">
                                    <div class="new-order__step-header">
                                        <p class="new-order__step-counter">2</p>
                                        <h3 class="new-order__step-title">Способ оплаты<sup></sup>
                                        </h3>
                                    </div>
                                    <div class="new-order__gap">
                                        <div class="checkbox-radio">
                                            <div>
                                                <input class="checkbox-radio__button" type="radio" name="pay" id="radio8" value="1" checked="checked">
                                                <label class="checkbox-radio__label" for="radio8">Картой
                                                    на сайте</label>
                                            </div>
                                            <div>
                                                <input class="checkbox-radio__button" type="radio" name="pay" id="radio9" value="1">
                                                <label class="checkbox-radio__label" for="radio9">Безналичным
                                                    платежом</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Адрес самовывоза:</b>
                                        <p class="new-order__address">Московская область, город Одинцово, ул. ....</p>

                                        <b>Время работы склада:</b>
                                        <p class="new-order__address">9:00 - 20:00</p>

                                        <p class="new-order__address">Дату подготовки заказа к выдаче вам сообщит менеджер</p>
                                    </div>
                                </section>
                            </section>
                        </section>
                    </div>

                    <div class="new-order__info">
                        <h3 class="new-order__subtitle">Ваш заказ</h3>

                        <table class="new-order__table-info">
                            <tbody>
                            <tr>
                                <td class="new-order__table-header">Стоимость заказа</td>
                                <td>{{ $amount }} руб</td>
                            </tr>
                            <tr>
                                <td class="new-order__table-header">Стоимость доставки</td>
                                <td id="deliveryPrice">через менеджера</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="new-order__table-header">
                                    <a id="calcBtn" class="new-order__table-link" data-type="managerCalc">Использовать автоматический
                                        расчет</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="new-order__table-header">Итого</td>
                                <td id="totalPrice">{{ $amount }} руб.</td>
                            </tr>
                            <tr>
                                <td class="new-order__table-header">Оплата</td>
                                <td>картой на сайте</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="form__agreement">
                            <input class="form__checkbox js-checkbox" type="checkbox" id="agreement" name="checkbox" data-required>
                            <label for="agreement" class="form__agreement-text">
                                Я соглашаюсь на
                                <a href="" class="form__agreement-link">обработку персональных
                                    данных</a>
                                и подтверждаю
                                <a href="" class="form__agreement-link">условия доставки и
                                    хранения заказа</a>
                            </label>
                        </div>

                        @if ($amount >= 5000)
                            <button class="form__buy-btn js-form-submit">Оформить заказ</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('pages.footer_pages')
</div>
@include('layout.part.js')
</html>


<script>
    ymaps.ready(init);

    let timeout = null;

    var stringAddress = document.querySelector("#stringAddress"),
        calcBtn = document.getElementById("calcBtn"),
        deliveryPrice = document.getElementById("deliveryPrice"),
        deliveryType,
        time = document.querySelectorAll("input[name='time']"),
        orderTab = document.querySelectorAll(".new-order__tab");


    orderTab.forEach(function(elem) {
        elem.addEventListener("click", (event) => {
            if (event.target.getAttribute('data-tab-btn') == "pickup")
            {
                calcBtn.setAttribute('data-type', 'managerCalc');
                calcBtn.style.display = "none";
                deliveryPrice.innerHTML = "через менеджера";
                totalPrice.innerHTML = {{ $amount }}  + " руб.";
            }

            else {
                calcBtn.style.display = "block";
            }
        });
    });



    time.forEach(function(elem) {
        elem.addEventListener("change", (event) => {
            if (event.target.value == 3)
            {
                calcBtn.setAttribute('data-type', 'managerCalc');
                calcBtn.innerHTML = "Использовать автоматический расчет";
                deliveryPrice.innerHTML = "через менеджера";
                totalPrice.innerHTML = {{ $amount }}  + " руб.";
            }
        });
    });


    calcBtn.addEventListener("click", (event) => {
        if (calcBtn.getAttribute('data-type') == "managerCalc")
        {
            calcBtn.setAttribute('data-type', 'autoCalc');
            calcBtn.innerHTML = "Использовать расчет через менеджера";
            getDeliveryPrice();
        }

        else {
            calcBtn.setAttribute('data-type', 'managerCalc');
            calcBtn.innerHTML = "Использовать автоматический расчет";
            deliveryPrice.innerHTML = "через менеджера";
            totalPrice.innerHTML = {{ $amount }}  + " руб.";
        }
    });

    let inputArray = document.querySelectorAll("input");

    inputArray.forEach(function(elem) {
        elem.addEventListener("change", (event) => {
            getDeliveryPrice();
        });
    });

    stringAddress.addEventListener('keyup', function(evt) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            setCoords(stringAddress.value);
        }, 1000);
    });


    function init() {

        const mkadCoordinates = [[[55.897702887224796,37.67240905761718],[55.89664192633831,37.6752414703369],[55.89591852721012,37.67807388305662],[55.8956291637662,37.6829662322998],[55.89538802590739,37.687686920166],[55.89553270880329,37.69146347045898],[55.89529157034246,37.69669914245605],[55.89466460330075,37.69996070861816],[55.89312125646775,37.705282211303704],[55.89215663339145,37.70751380920409],[55.89152961547806,37.70957374572752],[55.89046848506115,37.712148666381815],[55.888635554797155,37.715324401855455],[55.8874296322104,37.71798515319823],[55.88622367199341,37.720216751098604],[55.88545183770592,37.722448348999016],[55.884872951875,37.72493743896484],[55.884872951875,37.73025894165038],[55.88279853978146,37.73025894165038],[55.8811582281455,37.73111724853514],[55.880000319199695,37.7330913543701],[55.87903536858371,37.735065460205064],[55.87816689243558,37.737468719482415],[55.87464453915709,37.743562698364244],[55.86373768471359,37.76553535461424],[55.84804765603748,37.79574775695799],[55.833558904954586,37.8228702545166],[55.83148173964286,37.82776260375975],[55.83090204571783,37.83093833923339],[55.82925953247555,37.831968307495096],[55.824331574788744,37.83746147155761],[55.82186736083274,37.83866310119629],[55.81930634494508,37.83995056152341],[55.81640687737011,37.84115219116209],[55.815923611680155,37.84321212768552],[55.815198701844565,37.84458541870117],[55.814038817900894,37.84381294250486],[55.81244392079273,37.84252548217771],[55.81075229152879,37.84063720703125],[55.80698210925112,37.84106636047361],[55.80209966167469,37.841667175292955],[55.80011750252675,37.84192466735837],[55.780193594328715,37.84381294250486],[55.77913351008552,37.844783264391616],[55.77845628577709,37.84701486229202],[55.77792417267178,37.84813066124222],[55.776618045932416,37.84778733848831],[55.77526349769469,37.84581323265335],[55.773812143546046,37.844697433703146],[55.75997317538473,37.84426828026078],[55.753487486017335,37.84435411094925],[55.75198691106874,37.8441824495723],[55.74898558725352,37.84383912681839],[55.74675864876349,37.845555740587926],[55.7449673229946,37.84950395225785],[55.74482207674487,37.85173555015823],[55.74332116703625,37.85019059776566],[55.741481263136315,37.844869095080114],[55.736784271297495,37.8430666506221],[55.73179612239952,37.84289498924515],[55.731166504711425,37.844697433703146],[55.72898698012023,37.84177919029495],[55.72491820726679,37.841521698229506],[55.72080056319119,37.84092088341019],[55.71818442163351,37.845126587145536],[55.716585581821896,37.84435411094925],[55.71571345967627,37.840405899279325],[55.713823794608125,37.84135003685256],[55.7119340377362,37.84461160301467],[55.710722606838814,37.84461160301467],[55.709414219096786,37.84169335960648],[55.70985035323334,37.83731599449416],[55.70849347541899,37.83851762413284],[55.70645806996491,37.83971925377152],[55.70587650599171,37.83774514793656],[55.705149538801436,37.83551355003615],[55.70350169621928,37.8343119203975],[55.701708376470975,37.833110290758825],[55.69758827484921,37.83216615318557],[55.69356469588598,37.83156533836623],[55.6894922165988,37.832766968004904],[55.686631530014225,37.83499856590531],[55.684207054812255,37.83748765587111],[55.6821703789833,37.83499856590531],[55.680279084622,37.834655243151396],[55.678775682559596,37.83620019554396],[55.675235183954115,37.83723016380569],[55.667182989135455,37.840405899279325],[55.66053624948339,37.84203668236037],[55.65641179002368,37.84263749717971],[55.6535972024768,37.84014840721388],[55.64859838232795,37.83448358177445],[55.64529783914648,37.83027787803908],[55.64243390621512,37.82572885154982],[55.63913284127208,37.824613052599645],[55.637919144215985,37.818604904406286],[55.62854813179519,37.80358453392288],[55.61820341705874,37.78667588829299],[55.617086218110366,37.78899331688187],[55.614948878859664,37.78959413170121],[55.61509461025296,37.7873625338008],[55.614997456051206,37.784444290392614],[55.614997456051206,37.78075357078811],[55.61120825360195,37.773543792956076],[55.60217097907149,37.75852342247268],[55.59726276567736,37.74642129539749],[55.59342323822858,37.736464935534215],[55.59118739019748,37.733718353502965],[55.58875697549044,37.73251672386429],[55.58875697549044,37.72891183494826],[55.5889514142296,37.72530694603226],[55.58584027831145,37.71826882957717],[55.58345814747422,37.7134623110225],[55.58127034840715,37.7057375490596],[55.57845033787414,37.69964357017777],[55.577088880670665,37.695094543688505],[55.575532871526356,37.692691284411154],[55.57358777301203,37.692262130968786],[55.57120489546283,37.69234796165726],[55.57188573243677,37.689773041002965],[55.57266381732086,37.68642564415238],[55.572128885626164,37.68239160179398],[55.57057267908735,37.67071862816117],[55.57042678154921,37.655612426989286],[55.57086447253071,37.645570236437536],[55.571496684188844,37.63930459617874],[55.57208025510925,37.63381143211625],[55.57208025510925,37.62437005638381],[55.57266381732086,37.621108490221694],[55.57353914430943,37.61527200340529],[55.57383091561797,37.61115213035842],[55.573879543957716,37.606860595934606],[55.573101483264445,37.603684860460966],[55.57144805288571,37.60196824669143],[55.56896777623045,37.60308404564163],[55.56648734226576,37.601624923937536],[55.5659036878825,37.59759088157914],[55.56673052902162,37.59467263817092],[55.57008635184344,37.593642669909215],[55.57378228721773,37.59252687095901],[55.57601913103611,37.58969445823929],[55.57699163191336,37.5841154634883],[55.57854758300307,37.577163177721715],[55.579617263456626,37.5727858126094],[55.58039519449406,37.569524246447294],[55.58195101012762,37.56188531517287],[55.58972915951208,37.530900436632834],[55.58919446129312,37.52729554771683],[55.590652711931135,37.52592225670121],[55.592256724782665,37.52223153709671],[55.59313161313196,37.5185408174922],[55.59415229144777,37.51373429893752],[55.59677677040253,37.50738282799025],[55.599012298609146,37.50369210838577],[55.60192801271931,37.49931474327346],[55.604843509200315,37.49776979088089],[55.60722433656079,37.494594055407255],[55.6090220079864,37.491332489245146],[55.60790454629169,37.48910089134476],[55.60596105848462,37.48747010826369],[55.611256835447605,37.488585907213896],[55.61412305735588,37.48686929344436],[55.61834913630358,37.48111863731642],[55.62340040051834,37.47622628807327],[55.62786828167662,37.47099061607619],[55.632044316744654,37.46661325096388],[55.63592859929264,37.46172090172073],[55.63665685921782,37.458373504870146],[55.63626845561624,37.45622773765824],[55.63578294567616,37.45348115562697],[55.63811333828267,37.455111938708036],[55.64068631839994,37.455541092150426],[55.64660838237857,37.44910379051468],[55.6556353723766,37.43837495445512],[55.65903208541546,37.43416925071975],[55.659905478070506,37.431079345934585],[55.66063329033317,37.42884774803421],[55.660875891400586,37.426616150133825],[55.66330181902196,37.429105240099624],[55.66655232529556,37.427817779772475],[55.680279084622,37.4175180971553],[55.688910399066174,37.41305490135452],[55.69293445909798,37.407990890734396],[55.698994005599275,37.40052362083694],[55.70049662715336,37.39691873192091],[55.702726216740054,37.39503045677445],[55.705343398046864,37.393142181627965],[55.70626421627299,37.39176889061234],[55.70960805709442,37.3874773561885],[55.71144946990421,37.38567491173048],[55.71237014362427,37.382413345568374],[55.712757789198164,37.38078256248733],[55.714938223574464,37.3838724672725],[55.718620457447926,37.38224168419143],[55.72307743204297,37.38009591697952],[55.72661358103612,37.378207641833036],[55.72985880462025,37.37657685875199],[55.72981037043872,37.37219949363968],[55.72951976408239,37.36653466820022],[55.73005254074289,37.3611273348262],[55.731892985754094,37.37134118675492],[55.734992485659596,37.373057800524435],[55.74501573829052,37.368680435412145],[55.751212398090566,37.36773629783889],[55.76215096246012,37.36799378990431],[55.76418345353268,37.36550469993851],[55.76655455864643,37.36610551475785],[55.76849004730127,37.368251281969755],[55.77158662843581,37.36567636131546],[55.77361862555876,37.36893792747757],[55.77739205226982,37.36893792747757],[55.7812134822765,37.36885209678909],[55.78493780505847,37.369023758166044],[55.787404367494126,37.37031121849319],[55.78943553645033,37.36885209678909],[55.791369884195,37.36430307029983],[55.792530446538024,37.374259430163114],[55.79562510967724,37.377520996325224],[55.80031498774618,37.381898361437536],[55.80442420841985,37.38533158897659],[55.808484657453775,37.387563186876974],[55.82303110743136,37.39185472130082],[55.83076121703942,37.39417214988967],[55.831727372273825,37.39099641441603],[55.83192060042838,37.388421493761754],[55.831775679402845,37.38558908104201],[55.83414265491183,37.38576074241899],[55.83568835674609,37.38782067894242],[55.834625693362945,37.392369705431676],[55.835640054497695,37.39554544090529],[55.839648936077,37.39468713402053],[55.84394715517475,37.391940551989286],[55.84814832383642,37.39133973716995],[55.85452164003844,37.39460130333206],[55.85959057388015,37.39674707054397],[55.86311429845631,37.399665313952184],[55.866782492613076,37.40378518699905],[55.86924384891148,37.407733398668974],[55.8718980772097,37.41219659446976],[55.873876565242476,37.418204742663114],[55.875565438348396,37.4226679384639],[55.87947369034666,37.43477006553909],[55.88121056442022,37.44077821373244],[55.884442872291174,37.4417223513057],[55.88285087383534,37.4453272402217],[55.88285087383534,37.44970460533402],[55.882995603677216,37.458287674181676],[55.883815729211854,37.46661325096388],[55.885745367711415,37.47339387535355],[55.888784352998634,37.48257775902054],[55.889122003279596,37.48549600242873],[55.889218474246576,37.488500076525426],[55.89119607599798,37.492619949572294],[55.89433109088146,37.49450822471878],[55.894041715548205,37.50043054222366],[55.90055213634929,37.51373429893752],[55.90416856273664,37.52214570640823],[55.9071096731802,37.532445389025426],[55.90826676999187,37.54059930443069],[55.91115936034281,37.54471917747756],[55.90870067235796,37.5464357912471],[55.91038802410236,37.56274362205765],[55.91130398417253,37.57338662742874],[55.91140039975807,37.58248468040726],[55.91072548560348,37.58737702965042],[55.91279839869436,37.59055276512405],[55.90870067235796,37.594071823351584],[55.90720609923871,37.6005949556758],[55.90508467033431,37.60797639488478],[55.90064857878059,37.626687484972685],[55.89789987512875,37.64428277611039],[55.89621197772044,37.65990396141311],[55.89577793503864,37.668057876818395],[55.897702887224796,37.67240905761718]]];
        var ttkCoordinates = [[[55.7738686,37.5488226],[55.7704772,37.5424625],[55.7704772,37.5424625],[55.7679391,37.5386223],[55.7679391,37.5386223],[55.7612438,37.5351513], [55.7612438,37.5351513],[55.7609823,37.5350457],[55.7609823,37.5350457],[55.7598777,37.5343711],[55.7598777,37.5343711],[55.7570828,37.5331783],[55.7570828,37.5331783], [55.7454398,37.5330879],[55.7454398,37.5330879],[55.7438473,37.5335315],[55.7438473,37.5335315],[55.7434773,37.5336527],[55.7434773,37.5336527],[55.7433807,37.5336899], [55.7433807,37.5336899],[55.7424470,37.5341062],[55.7424470,37.5341062],[55.7422969,37.5341791],[55.7422969,37.5341791],[55.7382658,37.5369487],[55.7382658,37.5369487],[55.7377628,37.5374810],[55.7377628,37.5374810],[55.7375064,37.5378606],[55.7375064,37.5378606],[55.7346510,37.5422121],[55.7346510,37.5422121],[55.7345114,37.5423524], [55.7345114,37.5423524],[55.7315028,37.5436940],[55.7315028,37.5436940],[55.7308472,37.5441562],[55.7308472,37.5441562],[55.7293886,37.5456174],[55.7293886,37.5456174], [55.7264278,37.5484680],[55.7264278,37.5484680],[55.7262565,37.5486041],[55.7262565,37.5486041],[55.7225083,37.5537777],[55.7225083,37.5537777],[55.7219511,37.5551745], [55.7219511,37.5551745],[55.7200231,37.5617878],[55.7200231,37.5617878],[55.7191497,37.5644848],[55.7191497,37.5644848],[55.7150404,37.5756357],[55.7150404,37.5756357], [55.7126203,37.5789091],[55.7126203,37.5789091],[55.7119254,37.5797746],[55.7119254,37.5797746],[55.7066724,37.5885664],[55.7066724,37.5885664],[55.7065215,37.5890862], [55.7065215,37.5890862],[55.7063547,37.5896611],[55.7063547,37.5896611],[55.7046792,37.5956343],[55.7046792,37.5956343],[55.7042147,37.5972745],[55.7042147,37.5972745], [55.7035627,37.5996636],[55.7035627,37.5996636],[55.7010618,37.6084629],[55.7010618,37.6084629],[55.7010188,37.6116040],[55.7010188,37.6116040],[55.7010877,37.6120093], [55.7010877,37.6120093],[55.7016318,37.6140501],[55.7016318,37.6140501],[55.7025163,37.6157588],[55.7025163,37.6157588],[55.7056751,37.6210290],[55.7056751,37.6210290], [55.7054922,37.6257451],[55.7054922,37.6257451],[55.7054589,37.6262217],[55.7054589,37.6262217],[55.7050692,37.6300899],[55.7050692,37.6300899],[55.7045239,37.6354485], [55.7045239,37.6354485],[55.7043622,37.6370175],[55.7043622,37.6370175],[55.7038949,37.6419184],[55.7038949,37.6419184],[55.7038431,37.6424455],[55.7038431,37.6424455], [55.7037308,37.6436327],[55.7037308,37.6436327],[55.7030971,37.6544139],[55.7030971,37.6544139],[55.7030928,37.6552728],[55.7030928,37.6552728],[55.7039650,37.6592981], [55.7039650,37.6592981],[55.7057339,37.6625304],[55.7057339,37.6625304],[55.7095752,37.6694375],[55.7095752,37.6694375],[55.7118910,37.6738934],[55.7118910,37.6738934], [55.7120490,37.6742841],[55.7120490,37.6742841],[55.7168348,37.6890221],[55.7168348,37.6890221],[55.7174433,37.6913696],[55.7174433,37.6913696],[55.7197334,37.7000532], [55.7197334,37.7000532],[55.7222234,37.7090355],[55.7222234,37.7090355],[55.7226851,37.7104891],[55.7226851,37.7104891],[55.7229496,37.7112863],[55.7229496,37.7112863], [55.7244625,37.7126533],[55.7244625,37.7126533],[55.7255059,37.7119574],[55.7255059,37.7119574],[55.7341345,37.7013012],[55.7341345,37.7013012],[55.7438001,37.6985058], [55.7438001,37.6985058],[55.7444010,37.6989104],[55.7444010,37.6989104],[55.7480731,37.6994670],[55.7480731,37.6994670],[55.7486438,37.6990756],[55.7486438,37.6990756], [55.7494717,37.6984108],[55.7494717,37.6984108],[55.7498889,37.6980284],[55.7498889,37.6980284],[55.7513251,37.6965021],[55.7513251,37.6965021],[55.7753465,37.6832547], [55.7753465,37.6832547],[55.7765911,37.6814829],[55.7765911,37.6814829],[55.7767355,37.6812355],[55.7767355,37.6812355],[55.7772325,37.6802746],[55.7772325,37.6802746], [55.7774819,37.6796783],[55.7774819,37.6796783],[55.7775934,37.6793688],[55.7775934,37.6793688],[55.7787706,37.6760722],[55.7787706,37.6760722],[55.7833524,37.6663784], [55.7833524,37.6663784],[55.7838700,37.6657042],[55.7838700,37.6657042],[55.7845890,37.6647649],[55.7845890,37.6647649],[55.7869004,37.6617482],[55.7869004,37.6617482], [55.7880590,37.6602844],[55.7880590,37.6602844],[55.7905644,37.6569959],[55.7905644,37.6569959],[55.7911066,37.6562753],[55.7911066,37.6562753],[55.7927893,37.6537517], [55.7927893,37.6537517],[55.7924285,37.6397458],[55.7924285,37.6397458],[55.7920607,37.6369066],[55.7920607,37.6369066],[55.7922336,37.6301634],[55.7922336,37.6301634], [55.7925896,37.6281494],[55.7925896,37.6281494],[55.7928408,37.6235483],[55.7928408,37.6235483],[55.7931757,37.6169961],[55.7931757,37.6169961],[55.7931245,37.6129701], [55.7931245,37.6129701],[55.7928882,37.6065660],[55.7928882,37.6065660],[55.7928418,37.6052135],[55.7928418,37.6052135],[55.7926627,37.6008183],[55.7926627,37.6008183], [55.7925420,37.5991276],[55.7925420,37.5991276],[55.7922792,37.5958078],[55.7922792,37.5958078],[55.7922370,37.5931111],[55.7922370,37.5931111],[55.7922391,37.5853027], [55.7922391,37.5853027],[55.7923347,37.5828517],[55.7923347,37.5828517],[55.7920311,37.5782999],[55.7920311,37.5782999],[55.7920035,37.5776925],[55.7920035,37.5776925], [55.7919744,37.5769938],[55.7919744,37.5769938],[55.7919487,37.5759922],[55.7919487,37.5759922],[55.7919388,37.5756045],[55.7919388,37.5756045],[55.7918094,37.5746670], [55.7918094,37.5746670],[55.7903140,37.5722409],[55.7903140,37.5722409],[55.7897744,37.5715105],[55.7897744,37.5715105],[55.7885390,37.5697519],[55.7885390,37.5697519], [55.7871056,37.5677689],[55.7871056,37.5677689],[55.7859934,37.5662136],[55.7859934,37.5662136],[55.7851408,37.5650213],[55.7851408,37.5650213],[55.7829418,37.5620143], [55.7829418,37.5620143],[55.7825828,37.5614679],[55.7825828,37.5614679],[55.7801185,37.5580600],[55.7801185,37.5580600],[55.7797878,37.5576799],[55.7797878,37.5576799], [55.7771397,37.5556459],[55.7771397,37.5556459],[55.7768090,37.5554052],[55.7768090,37.5554052],[55.7754019,37.5542038],[55.7754019,37.5542038],[55.7748064,37.5533163], [55.7748064,37.5533163],[55.7747286,37.5531606],[55.7747286,37.5531606],[55.7745479,37.5527585],[55.7745479,37.5527585],[55.7743488,37.5522090],[55.7743488,37.5522090], [55.7740380,37.5505311],[55.7740380,37.5505311],[55.7740080,37.5502350],[55.7740080,37.5502350],
            // [55.7738686,37.5488226],
            // [55.7919186,37.6369404],
            // [55.7921064,37.6388761],
            // [55.7921064,37.6388761],[55.7922866,37.6398347],[55.7922866,37.6398347],[55.7926715,37.6535807],[55.7926715,37.6535807],[55.7922868,37.6543134],[55.7922868,37.6543134],
            // [55.7879562,37.6600357],[55.7879562,37.6600357],[55.7867978,37.6615006],[55.7867978,37.6615006],[55.7857279,37.6629059],[55.7857279,37.6629059],[55.7854563,37.6632593],
            // [55.7854563,37.6632593],[55.7844479,37.6645567],[55.7844479,37.6645567],[55.7836760,37.6656280],[55.7836760,37.6656280],[55.7832811,37.6661541],[55.7832811,37.6661541],
            // [55.7786208,37.6759550],[55.7786208,37.6759550],[55.7774598,37.6792132],[55.7774598,37.6792132],[55.7771180,37.6801088],[55.7771180,37.6801088],[55.7769737,37.6804094],
            // [55.7769737,37.6804094],[55.7765086,37.6812801],[55.7765086,37.6812801],[55.7752626,37.6830546],[55.7752626,37.6830546],[55.7742681,37.6843535],[55.7742681,37.6843535],[55.7671420,37.6878516],[55.7671420,37.6878516],[55.7610110,37.6845701],[55.7610110,37.6845701],[55.7599972,37.6844786],[55.7599972,37.6844786],[55.7598111,37.6845203],[55.7598111,37.6845203],[55.7590678,37.6848754],[55.7590678,37.6848754],[55.7510844,37.6964085],[55.7510844,37.6964085],[55.7502420,37.6972556],[55.7502420,37.6972556],[55.7486675,37.6987609],[55.7486675,37.6987609],[55.7480623,37.6991522],[55.7480623,37.6991522],[55.7362513,37.6987711],[55.7362513,37.6987711],[55.7272270,37.7095253],[55.7272270,37.7095253],[55.7261457,37.7108497],[55.7261457,37.7108497],[55.7253762,37.7113028],[55.7253762,37.7113028],[55.7229279,37.7084266],[55.7229279,37.7084266],[55.7206669,37.7023224],[55.7206669,37.7023224],[55.7204215,37.7014994],[55.7204215,37.7014994],[55.7185005,37.6951358],[55.7185005,37.6951358],[55.7158354,37.6848782],[55.7158354,37.6848782],[55.7117280,37.6728294],[55.7117280,37.6728294],[55.7034376,37.6490866],[55.7034376,37.6490866],[55.7045640,37.6369655],[55.7045640,37.6369655],[55.7052313,37.6301405],[55.7052313,37.6301405],[55.7056211,37.6262724],[55.7056211,37.6262724],[55.7056826,37.6256984],[55.7056826,37.6256984],[55.7058627,37.6237233],[55.7058627,37.6237233],[55.7017789,37.6139451],[55.7017789,37.6139451],[55.7011724,37.6115166],[55.7011724,37.6115166],[55.7012085,37.6085133],[55.7012085,37.6085133],[55.7034950,37.6006013],[55.7034950,37.6006013],[55.7038541,37.5992579],[55.7038541,37.5992579],[55.7041974,37.5979806],[55.7041974,37.5979806],[55.7056285,37.5928617],[55.7056285,37.5928617],[55.7061444,37.5910577],[55.7061444,37.5910577],[55.7064176,37.5901622],[55.7064176,37.5901622],[55.7065235,37.5898214],[55.7065235,37.5898214],[55.7066996,37.5892552],[55.7066996,37.5892552],[55.7068290,37.5888391],[55.7068290,37.5888391],[55.7069339,37.5885413],[55.7069339,37.5885413],[55.7071683,37.5878758],[55.7071683,37.5878758],[55.7127322,37.5791894],[55.7127322,37.5791894],[55.7151473,37.5758569],[55.7151473,37.5758569],[55.7208370,37.5596875],[55.7208370,37.5596875],[55.7220809,37.5553112],[55.7220809,37.5553112],[55.7226254,37.5539617],[55.7226254,37.5539617],[55.7242877,37.5511014],[55.7242877,37.5511014],[55.7265046,37.5487240],[55.7265046,37.5487240],[55.7294637,37.5458562],[55.7294637,37.5458562],[55.7310798,37.5442743],[55.7310798,37.5442743],[55.7338744,37.5431354],[55.7338744,37.5431354],[55.7346148,37.5425822],[55.7346148,37.5425822],[55.7370078,37.5389504],[55.7370078,37.5389504],[55.7373487,37.5384200],[55.7373487,37.5384200],[55.7378826,37.5376955],[55.7378826,37.5376955],[55.7379957,37.5375534],[55.7379957,37.5375534],[55.7419697,37.5346023],[55.7419697,37.5346023],[55.7430282,37.5341109],[55.7430282,37.5341109],[55.7435101,37.5339494],[55.7435101,37.5339494],[55.7456871,37.5333789],[55.7456871,37.5333789],[55.7485505,37.5325730],[55.7485505,37.5325730],[55.7543802,37.5325086],[55.7543802,37.5325086],[55.7553999,37.5329776],[55.7553999,37.5329776],[55.7562028,37.5333279],[55.7562028,37.5333279],[55.7582246,37.5341546],[55.7582246,37.5341546],[55.7657134,37.5374525],[55.7657134,37.5374525],[55.7664411,37.5378088],[55.7664411,37.5378088],[55.7669241,37.5380184],[55.7669241,37.5380184],[55.7678864,37.5387856],[55.7678864,37.5387856],[55.7737402,37.5488718],[55.7737402,37.5488718],[55.7739085,37.5505033],[55.7739085,37.5505033],[55.7739323,37.5507320],[55.7739323,37.5507320],[55.7746154,37.5533886],[55.7746154,37.5533886],[55.7746955,37.5535365],[55.7746955,37.5535365],[55.7765698,37.5555428],[55.7765698,37.5555428],[55.7831358,37.5626104],[55.7831358,37.5626104],[55.7850263,37.5652769],[55.7850263,37.5652769],[55.7858792,37.5664677],[55.7858792,37.5664677],[55.7864413,37.5672704],[55.7864413,37.5672704],[55.7905547,37.5728743],[55.7905547,37.5728743],[55.7909309,37.5734043],[55.7909309,37.5734043],[55.7917717,37.5802045],[55.7917717,37.5802045],[55.7919422,37.5827530],[55.7919422,37.5827530],[55.7920834,37.5853096],[55.7920834,37.5853096],[55.7921002,37.5857467],[55.7921002,37.5857467],[55.7921017,37.5931165],[55.7921017,37.5931165],[55.7921009,37.5947224],[55.7921009,37.5947224],[55.7921395,37.5958921],[55.7921395,37.5958921],[55.7923655,37.5988668],[55.7923655,37.5988668],[55.7924048,37.5993139],[55.7924048,37.5993139],[55.7926089,37.6030711],[55.7926089,37.6030711],[55.7926581,37.6044075],[55.7926581,37.6044075],[55.7926796,37.6052281],[55.7926796,37.6052281],[55.7927473,37.6066049],[55.7927473,37.6066049],[55.7929880,37.6129846],[55.7929880,37.6129846],[55.7930394,37.6169845],[55.7930394,37.6169845],[55.7926615,37.6235133],[55.7926615,37.6235133],[55.7926122,37.6245521],[55.7926122,37.6245521],[55.7925155,37.6263983],[55.7925155,37.6263983],[55.7923902,37.6282854],[55.7923902,37.6282854],[55.7920982,37.6300827],[55.7920982,37.6300827],
            // [55.7918656,37.6356588],[55.7918656,37.6356588],[55.7919170,37.6369023],[55.7919170,37.6369023],[55.7919186,37.6369404], [55.7738686,37.5488226]
        ]];



        window.mkadCoordinates = mkadCoordinates;

        window.myPlacemark;
        window.myMap = new ymaps.Map('new-order__map', {
            center: [55.753994, 37.622093],
            zoom: 9,
            controls: ['searchControl']
        }, {
            searchControlProvider: 'yandex#search'
        });

        window.ttkPolygon = new ymaps.Polygon(ttkCoordinates, {}, {visible: false});
        window.mkadPolygon = new ymaps.Polygon(mkadCoordinates, {}, {visible: false});


        window.myMap.geoObjects.add(window.mkadPolygon);
        window.myMap.geoObjects.add(window.ttkPolygon);

        ymaps.borders.load('RU', {'quality': 3}).then(function (geojson) {
            var regions = ymaps.geoQuery(geojson);
            // regions.search('properties.iso3166 = "RU-MOS"').setOptions('visible', 'true').addToMap(window.myMap);

            window.mosPolygon = regions.search('properties.iso3166 = "RU-MOW"').setOptions('visible', false).get(0);
            window.mowPolygon = regions.search('properties.iso3166 = "RU-MOS"').setOptions('visible', false).get(0);


            window.myMap.geoObjects.add(window.mosPolygon);
            window.myMap.geoObjects.add(window.mowPolygon);

        });


        var arPlacemarks = [];
        for (let i = 0; i < window.mkadCoordinates[0].length; i++)
        {
            arPlacemarks[i] = new ymaps.Placemark(window.mkadCoordinates[0][i]);
        }

        window.arPlacermarksRez = ymaps.geoQuery(arPlacemarks).addToMap(window.myMap).setOptions('visible', false);

        // Слушаем клик на карте.
        window.myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            if (!inMO(coords))
            {
                calcBtn.setAttribute('data-type', 'managerCalc')
                calcBtn.style.display = "none";
                calcBtn.innerHTML = "Использовать автоматический расчет";
                deliveryPrice.innerHTML = "через менеджера";
                totalPrice.innerHTML = {{ $amount }} + " руб.";
            }

            else {
                calcBtn.style.display = "block";
            }

            // Если метка уже создана – просто передвигаем ее.
            if (window.myPlacemark) {
                window.myPlacemark.geometry.setCoordinates(coords);
                window.myRoute.model.setReferencePoints([
                    [55.658286, 37.260223],
                    coords
                ]);
            }
            // Если нет – создаем.
            else {
                window.myPlacemark = createPlacemark(coords);
                window.myRoute = createRoute(coords);
                window.myRoute.model.setReferencePoints([
                    [55.658286, 37.260223],
                    coords
                ]);

                window.myMap.geoObjects.add(window.myPlacemark);

                window.myRoute.model.events.add('requestsuccess', function () {
                    // let duration = window.myRoute.getActiveRoute().properties.get("duration"),
                    //     distance = window.myRoute.getActiveRoute().properties.get("distance");
                    // window.myPlacemark.geometry.getCoordinates(), duration, distance
                    getDeliveryPrice();
                });

                // window.myMap.geoObjects.add(window.myRoute);

                // Слушаем событие окончания перетаскивания на метке.
                window.myPlacemark.events.add('dragend', function () {
                    getAddress(window.myPlacemark.geometry.getCoordinates());
                    getDeliveryPrice();
                });
            }
            getAddress(coords);

            if (!inMkad(coords))
            {
                window.toMkadRoute;

                var closestObject = window.arPlacermarksRez.getClosestTo(window.myPlacemark);

                const point = coords;

                if (window.toMkadRoute)
                {
                    window.toMkadRoute.model.setReferencePoints([
                        point, closestObject.geometry.getCoordinates()
                    ]);
                }

                else {
                    window.toMkadRoute = new ymaps.multiRouter.MultiRoute(
                        {
                            referencePoints: [ point, closestObject.geometry.getCoordinates() ], // точка А, точка Б(МКАД)
                            params: { results: 1 }
                        },
                        {
                            boundsAutoApply: true // чтобы маршрут был виден целиком на карте
                        }
                    );

                    // добавляем его на нашу карту
                    // window.myMap.geoObjects.add( window.toMkadRoute );

                    window.toMkadRoute.model.events.add('requestsuccess', function() {
                        console.log(window.toMkadRoute.getActiveRoute().properties.get("distance"));
                        // distance = window.toMkadRoute.getActiveRoute().properties.get("distance");
                    });

                }
            }
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        function createRoute(coords)
        {
            return new ymaps.multiRouter.MultiRoute({
                // Точки маршрута. Точки могут быть заданы как координатами, так и адресом.
                referencePoints: [
                    [55.658286, 37.260223],
                    coords
                ]
            }, {
                // Автоматически устанавливать границы карты так,
                // чтобы маршрут был виден целиком.
                boundsAutoApply: true
            });

        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            setStringAddress(coords);
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }

    async function setStringAddress(coords) {
        const url = '{{ route('basket.stringAddress') }}';

        let data = {
            coords: coords,
        }

        let fetchData = {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            }
        }

        let response = await fetch(url, fetchData),
            result = await response.json(),
            stringAddress = document.querySelector("#stringAddress");

        if (typeof result[0] !== "undefined") {
            stringAddress.value = result[0];
        }
    }

    async function setCoords(stringAddress) {
        const url = '{{ route('basket.coordsAddress') }}';

        let data = {
            stringAddress: stringAddress,
        }

        let fetchData = {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            }
        }

        let response = await fetch(url, fetchData),
            result = await response.json();

        if (typeof result[0] !== "undefined") {
            changePlacemark(result[0]["geo_lat"], result[0]["geo_lon"]);

        }
    }

    function changePlacemark(lat, lon)
    {
        window.myPlacemark.geometry.setCoordinates([lat, lon]);
        window.myMap.setCenter([lat, lon]);
    }

    function inMkad(lat, lon)
    {
        // Проверяем входят ли координаты адреса в область МКАДа
        if (window.mkadPolygon.geometry.contains(lat, lon)) {
            return true;
        }

        else {
            return false;
        }
    }

    function inTTK(lat, lon)
    {
        // Проверяем входят ли координаты адреса в область МКАДа
        if (window.ttkPolygon.geometry.contains(lat, lon)) {
            return true;
        }
        else {
            return false;
        }
    }

    function inMO(lat, lon)
    {
        // Проверяем входят ли координаты адреса в область МКАДа
        if (window.mowPolygon.geometry.contains(lat, lon) || window.mosPolygon.geometry.contains(lat, lon)) {
            return true;
        }
        else {
            return false;
        }
    }


    async function getDeliveryPrice() {
        console.log(calcBtn.getAttribute('data-type'));
        if (calcBtn.getAttribute('data-type') == "autoCalc") {
            let fdata = new FormData(orderForm);

            for (const [key, value] of fdata.entries()) {
                // console.log(key, value);
            }

            const url = '{{ route('basket.getDeliveryPrice') }}';

            let coords = window.myPlacemark.geometry.getCoordinates();

            if (!inMkad(coords)) {
                var toMkadDistance = window.toMkadRoute.getActiveRoute().properties.get("distance");
            }

            let
                data = {
                    coords: coords,
                    inMkad: inMkad(coords),
                    toMkadDistance: toMkadDistance,
                    inTTK: inTTK(coords),
                    inMO: inMO(coords),
                    duration: window.myRoute.getActiveRoute().properties.get("duration"),
                    distance: window.myRoute.getActiveRoute().properties.get("distance"),
                    manipulator: manipulator.checked,
                    unload: unload.checked,
                    lift: lift.checked,
                    opt: fdata.get('opt'),
                    floor: fdata.get('floor'),
                    techFloor: fdata.get('techFloor'),
                    overCarry: fdata.get('overCarry'),
                    overCarryValue: fdata.get('overCarryValue'),
                    cleaning: fdata.get('cleaning'),
                }

            let fetchData = {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    "X-CSRF-Token": document.querySelector('input[name=_token]').value
                }
            }

            let response = await fetch(url, fetchData),
                result = (await response.json()).original.data;

            console.log(result);

            deliveryPrice.innerHTML = result['totalPrice'] + " руб.";
            totalPrice.innerHTML = Math.round(({{ $amount }} + result['totalPrice']) * 100) / 100  + " руб.";

            return result;
        }
    }


    orderForm.addEventListener('submit', function (event)
    {
        event.preventDefault();
        saveOrder();
    });

    async function saveOrder() {
        const url = '{{ route('basket.saveNewOrder')  }}';

        var tabActive = document.querySelector(".new-order__tab.active"),
            fdata = new FormData(orderForm),
            manager_comment = {},
            delivery = {
                order_type: 'через менеджера'
            };

        if (fdata.get('heightRest')) {
            manager_comment['Есть ограничение по высоте'] = "Да";

            if (fdata.get('heightRestValue')) {
                manager_comment['Ограничение по высоте'] = fdata.get('heightRestValue');
            }
        }

        if (fdata.get('techFloor')) {
            manager_comment['Технический этаж'] = "Да";
        }

        if (delivery['needTransport'].length > 1) {
            manager_comment['Необходимо более одного транспорта'] = "Да";
        }

        if (fdata.get('time') && fdata.get('time') == 3) {
            manager_comment['Ночная доставка'] = "Да";
        }

        if (delivery['inMO'])
        {
            manager_comment['Доставка за пределы МО'] = "Да";
        }

        if (tabActive.getAttribute('data-tab-btn') == "delivery")
        {
            delivery = await getDeliveryPrice();
        }

        if (fdata.get('masterName'))
        {
            delivery.master_name = fdata.get('masterName');
        }

        if (fdata.get('masterName'))
        {
            delivery.master_phone = fdata.get('masterPhone');
        }

        if (fdata.get('masterName'))
        {
            delivery.driver_comment = fdata.get('driverComment');
        }


        console.log(delivery, manager_comment);

        let
            data = {
                name: fdata.get('name'),
                email: fdata.get('email'),
                order_type: tabActive.getAttribute('data-tab-btn'),
                phone: fdata.get('phone'),
                address: fdata.get('address'),
                manager_comment: JSON.stringify(manager_comment),
                delivery: JSON.stringify(delivery),
                date_start: fdata.get('range-start'),
                date_end: fdata.get('range-end'),
                time: fdata.get('time'),
                comment: fdata.get('comment'),
                payment_type: fdata.get('pay'),
                delivery_price: delivery['totalPrice'] ? delivery['totalPrice'] : 0,
                total_price: (delivery['totalPrice'] ? delivery['totalPrice'] : 0) + {{ $amount }}
            }

        let fetchData = {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            }
        }

        let response = await fetch(url, fetchData),
            result = (await response.json());

        console.log(result);

    }

</script>
