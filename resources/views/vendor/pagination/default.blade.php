@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <a class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled" rel="prev" aria-label="@lang('pagination.previous')" href="{{ $paginator->previousPageUrl() }}">Предыдущая страница</a>
                </li>
            @else
                <li>
                    <a class="pagination__arrow pagination__arrow--prev pagination__arrow" rel="prev" aria-label="@lang('pagination.previous')" href="{{ $paginator->previousPageUrl() }}">Предыдущая страница</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pagination__button pagination__button--active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="pagination__button" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="pagination__arrow pagination__arrow--next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Следующая страница</a>
                </li>
            @else

                <li>
                    <a class="pagination__arrow pagination__arrow--next pagination__arrow--disabled" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Следующая страница</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
