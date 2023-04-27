<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <textarea class="wysiwyg" name="{{ $field }}">{{ $data }}</textarea>
</div>