<footer class="footer">
    <div class="footer__container container">
        @foreach($items as $page)
            <div class="footer__col" data-spoilers="800">
                <h4 class="footer__title" data-spoiler>{{ $page->name }}</h4>
                <div class="footer__list">
                    @foreach($page->childrens as $children)
                        <a class="footer__link" href="{{ route('pages.index', ['page' => $children->slug]) }}">{{ $children->name }}</a>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="footer__copy">
            © "Анистрой" 2022-2023. Все права защищены, <a class="footer__copy-link" href="#">читать подробнее.</a>
            <p>Информация на сайте не является публичной офертой. Наличие товара, количество и ассортимент подлежат уточнению до момента заключения договора купли-продажи</p>
        </div>
        <div class="footer__cards">
            <img src="{{ asset('images/mastercard.svg') }}" alt="mastercard">
            <img src="{{ asset('images/visa.svg') }}" alt="visa">
            <img src="{{ asset('images/mir.svg') }}" alt="mir">
        </div>
    </div>
</footer>
