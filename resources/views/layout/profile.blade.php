<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> {{ $title ?? 'Anistroy'}} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/index.8ff14a9889db2a568ce7.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/slider.77893fdbf14175a4d1ad.css') }}">

</head>
<body>
<div class="site-wrapper">
    <header class="header">
        <div class="header__container container">
            <a class="header__logo" href="{{ route('index') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
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
                    <a class="user-nav__link user-nav__link--fav" href="{{ route('favorite.index') }}">
                        <img class="user-nav__icon" src="{{ asset('images/icon-fav.svg') }}" alt="favorites">
                        <span class="user-nav__counter user-nav__counter--fav">0</span>
                        Избранное
                    </a>
                    <a class="user-nav__link user-nav__link--cart" href="{{ route('basket.index') }}">
                        <img class="user-nav__icon" src="{{ asset('images/icon-cart.svg') }}" alt="">
                        <span class="user-nav__counter user-nav__counter--cart">0</span>
                        Корзина
                    </a>
                    @if (auth()->user())
                        <!-- если залогинен -->
                        <a class="user-nav__link user-nav__link--profile" href="{{ route('profile.edit') }}">
                            <img class="user-nav__icon user-nav__icon--profile" src="{{ asset('images/icon-profile.svg') }}" alt="">
                            Профиль
                        </a>
                        <!-- --- -->
                    @else
                        <!-- если не залогинен -->
                        <a class="user-nav__link user-nav__link--login" href="{{ route('login') }}">
                            <img class="user-nav__icon user-nav__icon--login" src="{{ asset('images/icon-login.svg') }}" alt="">
                            Войти
                        </a>
                        <!-- --- -->
                    @endif
                </div>
            </div>

            <button class="header__mobile-menu">
                <span></span>
            </button>
        </div>
    </header>
    <main class="main">
        <div class="main__container container">
            @if (auth()->user())
                <aside class="aside-menu" data-spoilers="992,max">
                    <h2 class="aside-menu__title" data-spoiler><span>Личный кабинет</span></h2>
                    <ul class="aside-menu__list">
                        <li><a class="aside-menu__link @if(Route::is('profile.orders')) active @endif" href="{{ route('profile.orders') }}">Мои заказы</a></li>
{{--                        <li><a class="aside-menu__link" href="{{ route('bonus') }}">Бонусная программа</a></li>--}}
{{--                        <li><a class="aside-menu__link" href="{{ route('address') }}">Адреса доставки</a></li>--}}
                        <li><a class="aside-menu__link @if(Route::is('profile.edit')) active @endif" href="{{ route('profile.edit') }}">Мои данные</a></li>
                        <li><a class="aside-menu__link @if(Route::is('profile.change_password')) active @endif" href="{{ route('profile.change_password') }}">Смена пароля</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="aside-menu__link" type="submit">Выход</button>
                            </form>
                        </li>
                    </ul>

                </aside>
            @endif

            <div class="content">
                @yield("content")
            </div>
        </div>
    </main>
    @include('pages.footer_pages')
</div>
</body>
<script src="{{ asset('js/auth.f6bba4a20c4ae77f807e.js') }}"></script>
<script src="{{ asset('js/validate.7d8d21e0792b4b716efd.js') }}"></script>
<script src="{{ asset('js/catalog-and-spoiler.5b93e478149cef6b08ba.js') }}"></script>
<script src="{{ asset('js/header.725bb8121f6d16923273.js') }}"></script>
<script src="{{ asset('js/modal.c4556f2eebbfb77e49c4.js') }}"></script>
<script src="{{ asset('js/product-item.822b961ebf917d00668a.js') }}"></script>
<script src="{{ asset('js/54.d0fa7b73b5a57e677cd9.js') }}"></script>
<script src="{{ asset('js/slider.4e43f9d3b8ed5d964970.js') }}"></script>
<script src="{{ asset('js/cookie.cdb72658b07995caf8c5.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.57815a8e958fb878b943.js') }}"></script>
<script src="{{ asset('js/index.1777611d218d1a8828b2.js') }}"></script>
</html>
