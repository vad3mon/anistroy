<div class="invisible json_field_template" id="json_template_{{ $field }}" style="display: none;">
    <li class="edit__dragndrop">
        <span class="edit__drag-icon">&#8759;</span>
        @foreach($fieldData['json_fields'] as $jsonField)
            @switch($jsonField['type'])
                @case('line')
                    <input type="text" name="json_{{ $field }}_{{ $jsonField['name'] }}[]" value="" placeholder="{{ $jsonField['title'] }}">
                @break

                @case('enum')
                    <select name="json_{{ $field }}_{{ $jsonField['name'] }}[]">
                        @foreach($jsonField['values'] as $jsonFieldValue)
                            <option value="{{ $jsonFieldValue }}">{{ $jsonFieldValue }}</option>
                        @endforeach
                    </select> 
                @break
            @endswitch
        @endforeach
        <button class="json_remove" data-confirm="Точно удалить?">x</button>
    </li>   
</div>



<div class="edit__item">
    <label class="edit__label label" title="{{ isset($fieldData['hint']) ? $fieldData['hint'] : '' }}">
        {{ $fieldData['title'] }}
        <button class="edit__add-btn json_add" data-field="{{ $field }}">+</button>
    </label>
    <ul id="json_fields_{{ $field }}" class="json_sortable">
        @if(isset($data) && is_array($data))
            @foreach($data as $jsonFieldData)
                <li class="edit__dragndrop">
                    <span class="edit__drag-icon">&#8759;</span>
                    @foreach($fieldData['json_fields'] as $jsonField)
                        @switch($jsonField['type'])
                            @case('line')
                                <input class="input" type="text" name="json_{{ $field }}_{{ $jsonField['name'] }}[]" value="{{ isset($jsonFieldData[$jsonField['name']]) ? $jsonFieldData[$jsonField['name']] : '' }}" placeholder="{{ $jsonField['title'] }}">
                            @break

                            @case('enum')
                                <select name="json_{{ $field }}_{{ $jsonField['name'] }}[]">
                                    @foreach($jsonField['values'] as $jsonFieldValue)
                                        <option value="{{ $jsonFieldValue }}" {{ isset($jsonFieldData[$jsonField['name']]) && $jsonFieldValue ==$jsonFieldData[$jsonField['name']] ? 'selected' : ''}}>{{ $jsonFieldValue }}</option>
                                    @endforeach
                                </select> 
                            @break
                        @endswitch
                    @endforeach
                    <button class="json_remove edit__delete-btn" data-confirm="Точно удалить?"></button>
                </li>                                            
            @endforeach
        @endif
    </ul>
</div>





{{--

<div class="edit__item">
                <label class="edit__label label" for="4">Обсуждаем в соцсетях (ссылки ставим с https://)</label>
                <div class="edit__dragndrop">
                  <button class="edit__drag-btn"></button>
                  <select class="select" name="filter1" autocomplete="off" id="filter1">
                    <option value="1">telegram</option>
                    <option value="2">Категория</option>
                  </select>
                  <input class="input" type="text" name="" id="2" value="">
                  <button class="edit__delete-btn"></button>
                </div>
                <div class="edit__dragndrop">
                  <button class="edit__drag-btn"></button>
                  <select class="select" name="filter2" autocomplete="off" id="filter2">
                    <option value="1">telegram</option>
                    <option value="2">Категория</option>
                  </select>
                  <input class="input" type="text" name="" id="2" value="">
                  <button class="edit__delete-btn"></button>
                </div>
                <button class="edit__add-btn button-icon button-icon--add">Добавить</button>
              </div>

--}}              