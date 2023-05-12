<header class="header">
    <div class="header__top">
        <nav class="site-nav">
            <a class="phone-box phone-box--mobile" href="tel:88005558213">
                <img class="phone-box__icon" src="{{ asset('images/icon-phone.svg') }}" alt="">
                <span class="phone-box__text">
                8 (800) 555-82-13
              </span>
            </a>
            @include('pages.top_pages')
        </nav>

        @if (auth()->user())
            <nav class="profile-nav">
                <a class="profile-nav__link" href="{{ route('profile.edit') }}">{{ auth()->user()->name }}</a>
            </nav>
        @else
            <nav class="login-nav" data-submenu="login">
                <a class="login-nav__link" href="{{ route('login') }}">Вход</a>
                <a class="login-nav__link" href="{{ route('register') }}">Регистрация</a>
            </nav>
        @endif

    </div>

    <div class="header__bottom">
        <button class="header__mobile-menu">
            <span></span>
        </button>
        <a class="header__logo" href="{{ route('index') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo">
        </a>

        <form class="header__search-box" data-submenu="search" action="{{ route('catalog.search') }}">
            <input name="query" class="header__search-input" type="text" placeholder="Поиск по названию">
            <button class="header__submit-button" type="submit">Поиск</button>
        </form>

        <a class="phone-box phone-box--desktop" href="tel:88005558213">
            <img class="phone-box__icon" src="{{ asset('images/icon-phone.svg') }}" alt="">
            <span class="phone-box__text">
                8 (800) 555-82-13
              </span>
        </a>

        <div class="header__user-nav user-nav">
            <button class="user-nav__link user-nav__link--search" data-trigger="search"></button>
            <a class="user-nav__link user-nav__link--fav" href="{{ route('favorite.index') }}">
                <img class="user-nav__icon" src="{{ asset('images/icon-fav.svg') }}" alt="">
                @if (session()->get('inFav'))
                    <span class="user-nav__counter user-nav__counter--fav">{{ count(session()->get('inFav')) }}</span>
                @else
                    <span class="user-nav__counter user-nav__counter--fav">0</span>
                @endif

                Избранное
            </a>
            <a class="user-nav__link user-nav__link--cart" href="{{ route('basket.index') }}">
                <img class="user-nav__icon" src="{{ asset('images/icon-cart.svg') }}" alt="">
                @if (session()->get('inCart'))
                    <span class="user-nav__counter user-nav__counter--cart">{{ count(session()->get('inCart')) }}</span>
                @else
                    <span class="user-nav__counter user-nav__counter--cart">0</span>
                @endif

                Корзина
            </a>

            @if (auth()->user())
                <!-- если залогинен -->
                <a class="user-nav__link user-nav__link--profile" href="{{ route('profile.edit') }}">
                    <img class="user-nav__icon user-nav__icon--profile" src="{{ asset('images/icon-profile.svg') }}" alt="">
                </a>
            @else
                <!-- если не залогинен -->
                <button class="user-nav__link user-nav__link&#45;&#45;login" data-trigger="login">
                    <img class="user-nav__icon user-nav__icon&#45;&#45;login" src="{{ asset('images/icon-login.svg') }}" alt="">
                </button>

            @endif

        </div>
    </div>
</header>
