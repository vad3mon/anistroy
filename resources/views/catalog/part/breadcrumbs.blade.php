<ul class="breadcrumbs">
    <li class="breadcrumbs__item"><a href="{{ route('index') }}" class="breadcrumbs__link">Главная</a></li>

    @foreach($parentCategories as $parentCategory)
        <li class="breadcrumbs__item"><a href="{{ route('catalog.category', ['category' => $parentCategory]) }}" class="breadcrumbs__link">{{ $parentCategory->name }}</a></li>
    @endforeach

    <li class="breadcrumbs__item"><span class="breadcrumbs__current">{{ $product->name }}</span></li>
</ul>
