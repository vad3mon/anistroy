<div class="edit__item edit__item--single">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">{{ $fieldData['title'] }}</label>
    <select class="dropdown_one" name="{{ $field }}">
        @if(isset($fieldData['has_null']) && $fieldData['has_null'])
            <option>-</option>
        @endif

        @foreach($fieldData['values'] as $val => $valName)
            <option value="{{ $val }}" {{ (isset($data) && $data == $val) ? 'selected' : '' }}>{{ $valName }}</option>
        @endforeach
    </select>
</div>