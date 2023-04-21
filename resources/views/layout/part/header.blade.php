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
                <input name="query" class="header__search-input" type="text" placeholder="Поиск по названию">
                <button class="header__search-button active" type="button">Поиск</button>
                <button class="header__submit-button" type="submit">Поиск</button>
            </form>

            <div class="user-nav">
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
