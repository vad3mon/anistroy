<ul class="breadcrumbs">
    <li class="breadcrumbs__item"><a href="{{ route('index') }}" class="breadcrumbs__link">Главная</a></li>

    @foreach($parentCategories as $parentCategory)
        <li class="breadcrumbs__item">
            @if($parentCategory == $parentCategories->last())
                <span class="breadcrumbs__current">{{ $parentCategory->name }}</span>
            @else
                <a href="{{ route('catalog.category', ['category' => $parentCategory]) }}" class="breadcrumbs__link">{{ $parentCategory->name }}</a>
            @endif
        </li>
    @endforeach

    @isset($product) <li class="breadcrumbs__item"><span class="breadcrumbs__current">{{ $product->name }}</span></li> @endisset
</ul>
