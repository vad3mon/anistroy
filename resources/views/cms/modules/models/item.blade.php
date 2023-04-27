@extends('cms.layout')


@section('header')
    <div class="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Config::get('cms.modules')[$module]['name'] }}
        </h2>
        <a href="{{ route('cms.models.item', [$module, 'add']) }}" class="add_btn">Добавить</a>
    </div>
@endsection


@section('content')
    <form id="cms_data_form" action="{{ route('cms.models.save', [$module, $id]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="content__sticky">
            <div>
                <h2 class="content__title title-big">
                    <a href="{{ route('cms.models.home', $module) }}">
                        {{ Config::get('cms.modules')[$module]['name'] }}
                    </a>
                </h2>
                @if($request->input('parent'))
                    <a class="content__button-add" href="{{ route('cms.models.item', [$module, 'add', 'with_parent' => $request->input('parent')]) }}">+</a>
                @else
                    <a class="content__button-add" href="{{ route('cms.models.item', [$module, 'add']) }}">+</a>
                @endif 
            </div>
            @if($canSave)
                <button class="button-icon button-icon--save">
                    Сохранить
                </button>
            @endif
          </div>


        <div class="content__background">

            @if($goUpId)
                <input type="hidden" name="parent" value="{{ $goUpId }}".
            @endif

            <section class="edit">
                @forelse($editorFields as $field => $fieldData)
                    @include('cms.parts.editables.' . $fieldData['type'], [
                        'field' => $field, 
                        'fieldData' => $fieldData,
                        'data' => isset($item[$field]) ? $item[$field] : ''
                    ])
                @empty
                @endforelse
            </section>

            <p><br><br><br><br><br><br><br><br><br></p>
        </div>

    </form>

@endsection


@push('scripts')
    <script src="{{ asset('/cms/scripts/sortable-list/sortable-list.js') }}?v={{ rand(0, 99999) }}"></script>

    <link href="{{ asset('/cms/scripts/fancybox/fancybox.css') }}" rel="stylesheet">
    <script src="{{ asset('/cms/scripts/fancybox/fancybox.umd.js') }}"></script>

    {{--    <link href="{{ asset('/cms/scripts/selectr/selectr.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <script src="{{ asset('/cms/scripts/selectr/selectr.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('/cms/scripts/select-with-pos/style.css') }}">
    <script rel="script" src="{{ asset('/cms/scripts/select-with-pos/select-with-pos.js') }}"></script>

    <script src="{{ asset('/cms/scripts/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/cms/scripts/wysiwyg.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/json_fields.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/images.js') }}?v={{ rand(0, 999999) }}"></script>

    <script src="{{ asset('/cms/scripts/item.js') }}?v={{ rand(0, 999999) }}"></script>

@endpush