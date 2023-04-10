<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> {{ $title ?? 'Anistroy'}} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/index.a7f4569d5dc6e8b680aa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.77893fdbf14175a4d1ad.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
</head>
<body>
<div class="site-wrapper">
    <header class="header">
        <div class="header__container container">
            <a class="header__logo" href="{{ route('index') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>

            <div class="header__nav-wrapper">
                @include('pages.top_pages')

                <a class="header__phone-box" href="tel:+79221232234">
                    <img class="header__phone-icon" src="{{ asset('images/icon-phone.svg') }}" alt="">
                    <span class="header__phone-text">
                +7 922 123-22-34
              </span>
                </a>

                <form class="header__search-box" method="post" action="{{ route('catalog.search') }}">
                    @csrf
                    <input name="query" class="header__search-input" type="text" placeholder="Поиск по названию">
                    <button type="submit" class="header__search-button">Поиск</button>
                </form>

                <div class="user-nav">
                    <a class="user-nav__link user-nav__link--fav" href="{{ route('favorite.index') }}">
                        <img class="user-nav__icon" src="{{ asset('images/icon-fav.svg') }}" alt="">
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
                          <img class="user-nav__icon user-nav__icon--profile" src="images/icon-profile.svg" alt="">
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

            @if (Route::is('catalog.category'))
                <form action="{{ route('catalog.category', ['category' => $currentCategory]) }}" class="catalog__section init" data-spoilers>
                    <h3 class="catalog__section-header active" data-spoiler>Фильтр по параметрам</h3>

                    <div class="catalog__section-list init" data-spoilers>

                        @foreach($properties as $property)
                            <div class="catalog__section-item">
                                @if($property['type'] == 'range')
                                    <div class="catalog__range-slider range-slider">
                                        <p class="catalog__filter-title active" data-spoiler>{{ $property['title'] }}</p>
                                        <div>
                                            <div class="range-slider__counter">
                                                <input type="number" value="{{ request('filters.range' . $property['id'] . '.from', $property['values']['min']) }}" min="{{ $property['values']['min'] }}" max="{{ $property['values']['max'] }}" name="filters[range][{{ $property['id'] }}][from]">
                                                <input type="number" value="{{ request('filters.range' . $property['id'] . '.to', $property['values']['max']) }}" min="{{ $property['values']['min'] }}" max="{{ $property['values']['max'] }}" name="filters[range][{{ $property['id'] }}][to]">
                                            </div>
                                            <input value="{{ request('filters.range' . $property['id'] . '.from', $property['values']['min']) }}" min="{{ $property['values']['min'] }}" max="{{ $property['values']['max'] }}" step="500" type="range">
                                            <input value="{{ request('filters.range' . $property['id'] . '.to', $property['values']['max']) }}" min="{{ $property['values']['min'] }}" max="{{ $property['values']['max'] }}" step="500" type="range">
                                        </div>
                                    </div>

                                @elseif($property['type'] == 'list')
                                    <p class="catalog__filter-title active" data-spoiler>{{ $property['title'] }}</p>
                                    <ul class="catalog__filter-list">
                                        @foreach($property['values'] as $key => $value)
                                            <li class="catalog__filter-item">
                                                <input class="catalog__filter-input"
                                                       type="checkbox"
                                                       id="filters-properties-{{ $property['id'] }}-{{ $key }}"
                                                       name="filters[properties][{{ $property['id'] }}][{{ $value }}]"
                                                       value="{{ $value }}"
                                                       @checked(request('filters.properties.' . $property['id'] . '.' . $value))
                                                >
                                                <label class="catalog__filter-label" for="filters-properties-{{ $property['id'] }}-{{ $key }}">{{ $value }}</label>
                                            </li>
                                        @endforeach
                                    </ul>


                                @elseif($property['type'] == 'price')
                                    <div class="catalog__section-item">
                                        <div class="catalog__range-slider range-slider">
                                            <div class="range-slider__counter">

                                                <input type="number"
                                                       value="{{
                                                            request('filters.price.from', $property['values']['min']) >= $property['values']['min'] ?
                                                            request('filters.price.from', $property['values']['min']) : $property['values']['min']
                                                       }}"
                                                        min="{{ $property['values']['min'] }}"
                                                        max="{{ $property['values']['max'] - 1 }}"
                                                        name="filters[price][from]">

                                                <input type="number"
                                                       value="{{
                                                            request('filters.price.to', $property['values']['max']) <= $property['values']['max'] ?
                                                            request('filters.price.to', $property['values']['max']) : $property['values']['max']
                                                       }}"
                                                        min="{{ $property['values']['min'] + 1 }}"
                                                        max="{{ $property['values']['max'] }}"
                                                        name="filters[price][to]">
                                            </div>

                                            <input value="{{
                                                            request('filters.price.from', $property['values']['min']) >= $property['values']['min'] ?
                                                            request('filters.price.from', $property['values']['min']) : $property['values']['min']
                                                       }}"
                                                   min="{{ $property['values']['min'] }}"
                                                   max="{{ $property['values']['max'] - 1 }}"
                                                   step="{{ $property['values']['step'] }}"
                                                   type="range">

                                            <input value="{{
                                                            request('filters.price.to', $property['values']['max']) >= $property['values']['max'] ?
                                                            request('filters.price.to', $property['values']['max']) : $property['values']['max']
                                                       }}"
                                                   min="{{ $property['values']['min'] + 1 }}"
                                                   max="{{ $property['values']['max'] }}"
                                                   step="{{ $property['values']['step'] }}"
                                                   type="range">

                                        </div>

                                        <div class="catalog__button-box">
                                            <button class="catalog__show-btn" type="submit">Показать</button>
                                            <button class="catalog__reset-btn" type="reset">Сбросить</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    <div class="catalog__bubble">
                        <span>Найдено:  {{ $products->total() }}</span>
                        <button type="button" class="catalog__bubble-show">Показать</button>
                        <button type="button" class="catalog__bubble-close"></button>
                    </div>
                </form>
            @endif
        </section>





        <div class="content">
            @yield('content')
        </div>

    </div>
</main>

    @include('pages.footer_pages')

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

