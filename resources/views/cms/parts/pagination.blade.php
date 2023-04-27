@if($list->lastPage() > 1)
    <div class="pagination">
        @for ($page = 1; $page <= $list->lastPage(); $page++)
            @if($page == $list->currentPage())
                <span class="pagination__link current">{{ $page }}</span>
            @else
                <a class="pagination__link" href="{{ $list->path() }}?{{ Arr::query(array_merge($list->resolveQueryString(), ['page' => $page])) }}">{{ $page }}</a>
            @endif
                
        @endfor
    </div>
@endif