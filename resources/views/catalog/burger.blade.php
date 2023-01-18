<ul class="catalog__list">

    @foreach ($items as $category)
        @if ($category->childrenCategories && $category->childrenCategories->count())

            @include('categories/child_category', ['category' => $category])

        @else

            <li>
                <a class="catalog__link" href="{{ route('catalog.category', ['category' => $category]) }}">{{ $category->name }}</a>
            </li>

        @endif
    @endforeach
</ul>
