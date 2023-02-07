<li>
    <a class="catalog__sub" href="{{ route('catalog.category', ['category' => $category]) }}">{{ $category->name }}</a>
    <ul>
        @foreach($category->childrenCategories as $childCategory)

            @if ($childCategory->categories && $childCategory->categories->count())
                @include('catalog/part/child_category', ['category' => $childCategory])

            @else
                <li>
                    <a class="catalog__link" href="{{ route('catalog.category', ['category' => $childCategory]) }}">{{ $childCategory->name }}</a>
                </li>

            @endif

        @endforeach
    </ul>
</li>
