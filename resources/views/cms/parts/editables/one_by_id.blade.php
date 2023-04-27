<div class="edit__item edit__item--single">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <select class="dropdown_one" name="{{ $field }}">
        @if(isset($fieldData['has_null']) && $fieldData['has_null'])
            <option>-</option>
        @endif
        @foreach($additionalData[$field] as $key => $dt)
            <option value="{{ $dt->id }}" {{ $dt->id == $data ? 'selected' : '' }}>{{ $dt->name }}</option>
        @endforeach
    </select>
</div>