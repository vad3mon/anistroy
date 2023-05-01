<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> {{ $title ?? 'Anistroy'}} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    @include('layout.part.css')

</head>
<body>
<div class="site-wrapper">
    @include('layout.part.header')
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
<section class="cookie">
    <p>Оставаясь на нашем сайте, вы соглашаетесь с нашей <a class="cookie__link" href="{{ route('pages.index', ['page' => 'politika-obrabotki-personalnyh-dannyh']) }}"> политикой обработки персональных данных и использования кукис </a></p>
    <button class="cookie__save-btn">Соглашаюсь</button>
</section>
@include('layout.part.js')
</html>
