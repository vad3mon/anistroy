<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <textarea class="input textarea" name="{{ $field }}" {{ isset($fieldData['readonly']) && $fieldData['readonly'] ? 'readonly' : '' }}>{{ $data }}</textarea>
</div>