@foreach($items as $item)
    <a class="site-nav__link" href="{{ route('pages.index', ['page' => $item->slug]) }}">{{ $item->name }}</a>
@endforeach
