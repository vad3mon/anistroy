@extends ('layout.site', ['title' => 'Избранное'])

@section('content')
    <section class="fav">
        <h2 class="fav__title">Избранное</h2>
        @include('favorite.part.products', ['products' => $products])
    </section>
@endsection
