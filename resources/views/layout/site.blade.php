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
        <section class="catalog" data-spoilers>
            @isset($properties)<button class="catalog__filter-button" data-trigger="filter"></button>@endisset
            <h2 class="catalog__title" data-spoiler><span>Каталог товаров</span></h2>
            @include('catalog.burger')

            <section class="catalog__section init" data-spoilers>
                <h3 class="catalog__section-header active" data-spoiler>Уточнить раздел</h3>
                <div class="catalog__section-list">

                    @foreach ($categories as $category)

                        <a class="catalog__section-item catalog__section-item--link @if(array_key_exists('category', Route::current()->originalParameters())) {{Route::current()->originalParameters()['category'] == $category->slug ? "selected" : ""}} @endif" href="{{ route('catalog.category', ['category' => $category]) }}">
                            <span>{{ $category->name }}</span>

{{--                            @if ($category->childrenCategories && $category->childrenCategories->count())--}}
{{--                                <span>{{ $category->childrenCategories->count() }}</span>--}}
{{--                            @endif--}}
                        </a>
                    @endforeach
                </div>
            </section>

            @if (Route::is('catalog.category'))
                <form action="{{ route('catalog.category', ['category' => $currentCategory]) }}" class="catalog__section init catalog__filter" data-spoilers data-submenu="filter">
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
                                                       @checked(isset(request('filters.properties.' . $property['id'])[$value]) ? : '')
                                                >
                                                <label class="catalog__filter-label" for="filters-properties-{{ $property['id'] }}-{{ $key }}">{{ $value }}</label>
                                            </li>
                                        @endforeach
                                    </ul>


                                @elseif($property['type'] == 'price')
                                    <div class="catalog__section-item">
                                        <div class="catalog__range-slider range-slider">
                                            <p class="catalog__filter-title active" data-spoiler>{{ $property['title'] }}</p>
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
                                                            request('filters.price.to', $property['values']['max']) <= $property['values']['max'] ?
                                                            request('filters.price.to', $property['values']['max']) : $property['values']['max']
                                                       }}"
                                                   min="{{ $property['values']['min'] + 1 }}"
                                                   max="{{ $property['values']['max'] }}"
                                                   step="{{ $property['values']['step'] }}"
                                                   type="range">

                                        </div>

                                        <div class="catalog__button-box">
                                            <button class="catalog__show-btn" type="submit">Показать</button>
                                            <a class="catalog__reset-btn" type="button" href="{{ route('catalog.category', ['category' => $currentCategory]) }}">Сбросить</a>
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

<section class="cookie">
    <p>Оставаясь на нашем сайте, вы соглашаетесь с нашей <a class="cookie__link" href="{{ route('pages.index', ['page' => 'politika-obrabotki-personalnyh-dannyh']) }}"> политикой обработки персональных данных и использования кукис </a></p>
    <button class="cookie__save-btn">Соглашаюсь</button>
</section>


    @include('pages.footer_pages')

</div>


@include('layout.part.js')
</body>

</html>

