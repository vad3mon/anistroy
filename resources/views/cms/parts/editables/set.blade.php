<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <select class="dropdown_multy" name="{{ $field }}[]" multiple autocomplete="off">
        @foreach($additionalData[$field] as $dt)
            <option value="{{ $dt->id }}" {{ isset($additionalDataSelected[$field]) && $additionalDataSelected[$field]->find($dt->id) ? 'selected' : '' }}>{{ $dt[$fieldData['model_name_field'] ? $fieldData['model_name_field'] : 'name'] }}</option>
        @endforeach
    </select>
</div>