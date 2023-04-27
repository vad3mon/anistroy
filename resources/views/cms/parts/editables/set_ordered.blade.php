<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <select class="set_ordered" name="{{ $field }}[]" multiple autocomplete="off">
        @if(isset($additionalDataSelected[$field]))
            @foreach($additionalDataSelected[$field] as $dt)
                <option value="{{ $dt->id }}" selected>{{ $dt->name ? $dt->name : $dt->title }}</option>
            @endforeach
        @endif

        @foreach($additionalData[$field] as $dt)
            <option value="{{ $dt->id }}">{{ $dt->name ? $dt->name : $dt->title }}</option>
        @endforeach
    </select>
</div>