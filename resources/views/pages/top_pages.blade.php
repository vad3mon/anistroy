<nav class="site-nav">
    @foreach($items as $item)
        <a class="site-nav__link" href="{{ route('pages.index', ['page' => $item]) }}">{{ $item->name }}</a>
    @endforeach
</nav>
