<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <input class="input" type="text" name="{{ $field }}" value="{{ isset($data) ? $data : '' }}" {{ isset($fieldData['readonly']) && $fieldData['readonly'] ? 'readonly' : '' }}>
</div>