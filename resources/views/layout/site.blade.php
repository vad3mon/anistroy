<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> {{ $title ?? 'Anistroy'}} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/index.a7f4569d5dc6e8b680aa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.77893fdbf14175a4d1ad.css') }}">
</head>

<body>
<div class="site-wrapper">
    <header class="header">
        <div class="header__container container">
            <a class="header__logo" href="{{ route('index') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="">
            </a>

            <div class="header__nav-wrapper">
                <nav class="site-nav">
                    <a class="site-nav__link" href="about.html">О магазине</a>
                    <a class="site-nav__link" href="#">Доставка и оплата</a>
                    <a class="site-nav__link" href="#">Контакты</a>
                </nav>

                <a class="header__phone-box" href="tel:+79221232234">
                    <img class="header__phone-icon" src="{{ asset('images/icon-phone.svg') }}" alt="">
                    <span class="header__phone-text">
                +7 922 123-22-34
              </span>
                </a>

                <form class="header__search-box">
                    <input class="header__search-input" type="text" placeholder="Поиск по названию">
                    <button class="header__search-button">Поиск</button>
                </form>

                <div class="user-nav">
                    <a class="user-nav__link user-nav__link--fav" href="fav.html">
                        <img class="user-nav__icon" src="{{ asset('images/icon-fav.svg') }}" alt="">
                        <span class="user-nav__counter user-nav__counter--fav">0</span>
                        Избранное
                    </a>
                    <a class="user-nav__link user-nav__link--cart" href="{{ route('basket.index') }}">
                        <img class="user-nav__icon" src="{{ asset('images/icon-cart.svg') }}" alt="">
                        <span class="user-nav__counter user-nav__counter--cart">0</span>
                        Корзина
                    </a>
                    <!-- если залогинен -->
                    <!-- <a class="user-nav__link user-nav__link--profile" href="profile.html">
                      <img class="user-nav__icon user-nav__icon--profile" src="./assets/images/icon-profile.svg" alt="">
                      Профиль
                    </a> -->
                    <!-- --- -->

                    <!-- если не залогинен -->
                    <a class="user-nav__link user-nav__link--login" href="{{ route('login') }}">
                        <img class="user-nav__icon user-nav__icon--login" src="{{ asset('images/icon-login.svg') }}" alt="">
                        Войти
                    </a>
                    <!-- --- -->
                </div>
            </div>

            <button class="header__mobile-menu">
                <span></span>
            </button>
        </div>
    </header>

<main class="main">
    <div class="main__container container">
        <section class="catalog" data-spoilers>
            <h2 class="catalog__title" data-spoiler><span>Каталог товаров</span></h2>
            @include('catalog.burger')

            <section class="catalog__section init" data-spoilers>
                <h3 class="catalog__section-header active" data-spoiler>Уточнить раздел</h3>
                <div class="catalog__section-list">

                    @foreach ($categories as $category)
                        <a class="catalog__section-item catalog__section-item--link" href="{{ route('catalog.category', ['category' => $category]) }}">
                            <span>{{ $category->name }}</span>

                            @if ($category->childrenCategories && $category->childrenCategories->count())
                                <span>{{ $category->childrenCategories->count() }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>

            <form class="catalog__section init" data-spoilers>
                <h3 class="catalog__section-header active" data-spoiler>Фильтр по параметрам</h3>

                <div class="catalog__section-list init" data-spoilers>
                    <div class="catalog__section-item">
                        <p class="catalog__filter-title active" data-spoiler>Вес, кг</p>
                        <ul class="catalog__filter-list">
                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="1">
                                <label class="catalog__filter-label" for="1">1.11 (количество)</label>
                            </li>

                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="2">
                                <label class="catalog__filter-label" for="2">2.22 (количество)</label>
                            </li>
                        </ul>
                    </div>

                    <div class="catalog__section-item">
                        <p class="catalog__filter-title active" data-spoiler>Длина, мм</p>
                        <ul class="catalog__filter-list">
                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="3">
                                <label class="catalog__filter-label" for="3">100 (количество)</label>
                            </li>

                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="4">
                                <label class="catalog__filter-label" for="4">200 (количество)</label>
                            </li>
                        </ul>
                    </div>

                    <div class="catalog__section-item">
                        <p class="catalog__filter-title active" data-spoiler>Условия эксплуатации</p>
                        <ul class="catalog__filter-list">
                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="5">
                                <label class="catalog__filter-label" for="5">Внутри помещений с нормальной влажностью (1)</label>
                            </li>

                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="6">
                                <label class="catalog__filter-label" for="6">Внутри помещений с повышенной влажностью (3)</label>
                            </li>

                            <li class="catalog__filter-item">
                                <input class="catalog__filter-input" type="checkbox" id="7">
                                <label class="catalog__filter-label" for="7">Внутри сухих помещений (5)</label>
                            </li>


                        </ul>
                    </div>

                    <div class="catalog__section-item">
                        <div class="catalog__range-slider range-slider">
                            <div class="range-slider__counter">
                                <input type="number" value="25000" min="0" max="120000">
                                <input type="number" value="50000" min="0" max="120000">
                            </div>
                            <input value="25000" min="0" max="120000" step="500" type="range">
                            <input value="50000" min="0" max="120000" step="500" type="range">
                        </div>

                        <div class="catalog__button-box">
                            <button class="catalog__show-btn" type="button">Показать</button>
                            <button class="catalog__reset-btn" type="reset">Сбросить</button>
                        </div>
                    </div>
                </div>

                <div class="catalog__bubble">
                    <span>Найдено: 150 товаров</span>
                    <button type="button" class="catalog__bubble-show">Показать</button>
                    <button type="button" class="catalog__bubble-close"></button>
                </div>
            </form>
        </section>





        <div class="content">
            @yield('content')
        </div>

    </div>
</main>

    <footer class="footer">
        <div class="footer__container container">
            <div class="footer__col" data-spoilers="800">
                <h4 class="footer__title" data-spoiler>Организация</h4>
                <div class="footer__list">
                    <a class="footer__link" href="#">О компании</a>
                    <a class="footer__link" href="#">Услуги</a>
                    <a class="footer__link" href="#">Новости</a>
                    <a class="footer__link" href="#">Статьи</a>
                </div>
            </div>

            <div class="footer__col" data-spoilers="800">
                <h4 class="footer__title" data-spoiler>Как купить</h4>
                <div class="footer__list">
                    <a class="footer__link" href="#">Оплата</a>
                    <a class="footer__link" href="#">Доставка</a>
                    <a class="footer__link" href="#">Оптовый заказ</a>
                    <a class="footer__link" href="#">Контакты</a>
                </div>
            </div>

            <div class="footer__col" data-spoilers="800">
                <h4 class="footer__title" data-spoiler>Наш адрес</h4>
                <div class="footer__list">
                    <a class="footer__link" href="#">О компании</a>
                    <a class="footer__link" href="#">Услуги</a>
                    <a class="footer__link" href="#">Новости</a>
                    <a class="footer__link" href="#">Статьи</a>
                </div>
            </div>

            <div class="footer__col">
                <h4 class="footer__title">Мы на связи</h4>
                <div class="footer__list">
                    <a class="footer__link" href="#">О компании</a>
                    <a class="footer__link" href="#">Услуги</a>
                    <a class="footer__link" href="#">Новости</a>
                    <a class="footer__link" href="#">Статьи</a>
                </div>
            </div>
        </div>
    </footer>

</div>

</body>
<script src="{{ asset('js/header.247d4f67111134fa93dd.js') }}"></script>
<script src="{{asset('js/54.d0fa7b73b5a57e677cd9.js')}}"></script>
<script src="{{ asset('js/slider.4e43f9d3b8ed5d964970.js') }}"></script>
<script src="{{ asset('js/catalog-and-spoiler.72132c7401a28c7a9e7b.js') }}"></script>
<script src="{{ asset('js/imask.93caf3dc1c70c1a43a6d.js') }}"></script>
<script src="{{ asset('js/product-item.3c3baec3d647db3cf99f.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.57815a8e958fb878b943.js') }}"></script>
<script src="{{ asset('js/cart-form.634482d529a016264323.js') }}"></script>
<script src="{{ asset('js/auth.f6bba4a20c4ae77f807e.js') }}"></script>
<script src="{{ asset('js/modal.c4556f2eebbfb77e49c4.js') }}"></script>
<script src="{{ asset('js/index.e7bf726abb530d2c0754.js') }}"></script>
</html>

