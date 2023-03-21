<div class="product-info__block" id="about">
    <h2 class="product-info__title">Характеристики</h2>

    <div class="product-table">

        @foreach($product->properties()->get() as $property)
            <p class="product-table__item">
                <span class="product-table__key">{{ $property->title }}</span>
                <span class="product-table__value">{{ $property->pivot->value }}</span>
            </p>
        @endforeach

    </div>
</div>
