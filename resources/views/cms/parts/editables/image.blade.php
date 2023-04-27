<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <section class="load-file">
        @if(isset($data))
            <div class="load-file__result">
                <a href="{{ asset('storage/images/content/' . $data) }}" data-fancybox="gallery" class="image_{{ $field }}">
                    <img src="{{ $data ? asset('storage/images/cms_thumbnails/' . $data) : '' }}" alt="">
                </a>
            </div>
        @endif
        <input class="input" name="{{ $field }}" accept=".jpg, .jpeg, .png, .svg, .webp" type="file">

        <input name="image_{{ $field }}_delete" type="hidden" class="image_{{ $field }}_delete" value="">
        @if(isset($data))
            <button class="load-file__delete image_remove" data-image="{{ $field }}" data-confirm="Точно удалить?"></button>
        @endif
    </section>
</div>
