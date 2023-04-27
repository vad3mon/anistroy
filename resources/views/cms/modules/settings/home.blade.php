@extends('cms.layout')


@section('header')
    <div class="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Настройки
        </h2>
    </div>
@endsection


@section('content')
    <form id="cms_data_form" action="{{ route('cms.settings.save') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="content__sticky">
            <h2 class="title-big">Настройки</h2>

            @if($canSave)
                <button class="button-icon button-icon--save" type="submit">
                    Сохранить
                </button>
            @endif
        </div>

        <div class="content__background">

            <section class="content__tabs tabs">
                @foreach(Config::get('cms.settings') as $blockId => $settingsBlock)
                    <button class="tabs__item label {{ $loop->first ? 'active' : '' }}" data-block="{{ $blockId }}">{{ $settingsBlock['name'] }}</button>
                @endforeach
            </section>

            @foreach(Config::get('cms.settings') as $blockId => $settingsBlock)
                <div class="settings_block {{ $loop->first ? 'active' : '' }}" id="settings_block_{{ $blockId }}">
                    @foreach($settingsBlock['fields'] as $field => $fieldData)
                        @include('cms.parts.editables.' . $fieldData['type'], [
                            'field' => $field, 
                            'fieldData' => $fieldData,
                            'data' => isset($settings->settings[$field]) ? $settings->settings[$field] : ''
                        ])
                    @endforeach
                </div>
            @endforeach

            <p><br><br><br><br><br><br><br><br><br></p>

        </div>
    </form>

    <style>
        .settings_block {
            display: none;
        }
        
        .settings_block.active {
            display: block;
        }
    </style>


@endsection


@push('scripts')
    <script src="{{ asset('/cms/scripts/settings.js') }}?v={{ rand(0, 99999) }}"></script>

    <script src="{{ asset('/cms/scripts/sortable-list/sortable-list.js') }}?v={{ rand(0, 99999) }}"></script>

    <link href="{{ asset('/cms/scripts/fancybox/fancybox.css') }}" rel="stylesheet">
    <script src="{{ asset('/cms/scripts/fancybox/fancybox.umd.js') }}"></script>

    <link href="{{ asset('/cms/scripts/selectr/selectr.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('/cms/scripts/selectr/selectr.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('/cms/scripts/select-with-pos/style.css') }}">
    <script rel="script" src="{{ asset('/cms/scripts/select-with-pos/select-with-pos.js') }}"></script>

    <script src="{{ asset('/cms/scripts/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/cms/scripts/wysiwyg.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/json_fields.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/images.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/item.js') }}?v={{ rand(0, 999999) }}"></script>

@endpush