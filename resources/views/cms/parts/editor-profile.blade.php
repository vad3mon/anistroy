<header class="header">
    <section class="header__usercard usercard">
        <div class="usercard__header">
            <div class="usercard__info">
                <p class="usercard__name subtitle" href="">{{ Auth::user()->name }}</p>
                <p class="usercard__text">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="usercard__body">
            {{--
                <a class="usercard__link" href="">Редактировать</a>
                <a class="usercard__link" href="">Настройки</a>
            --}}
            <form method="post" action="{{ route('logout') }}">
                <button type="submit">
                    Выход
                </button>
            </form>
            {{-- <a class="usercard__link" href="">Выход</a> --}}
        </div>
    </section>
</header>