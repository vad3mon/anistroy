<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">
        {{ $fieldData['title'] }}
        <input type="checkbox" name="{{ $field }}" value="1" {{ $data ? 'checked' : '' }}>
    </label>
</div>