@extends('layout.site', ['title' => "Поиск"])

@section('content')

    <section class="all-products products">
        <h2 class="products__title">Результаты поиска</h2>

        <ul class="products__list">
            {{--        @each('catalog.part.product', $products, 'product')--}}
            @foreach($products as $product)
                @include('catalog.part.product')
            @endforeach
        </ul>



        {{ $products->links('vendor.pagination.default') }}
        <div class="pagination">

            {{--                    <a class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled" href="#">Предыдущая страница</a>--}}
            {{--                    <span class="pagination__button pagination__button--active">1</span>--}}
            {{--                    <a class="pagination__button" href="#">2</a>--}}
            {{--                    <a class="pagination__button" href="#">3</a>--}}
            {{--                    <a class="pagination__arrow pagination__arrow--next" href="#">Следующая страница</a>--}}
        </div>
    </section>

@endsection
