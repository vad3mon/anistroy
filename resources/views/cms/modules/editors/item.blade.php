@extends('cms.layout')


@section('header')
    <div class="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Пользователи
        </h2>
        <a href="{{ route('cms.editors.item', ['add']) }}" class="add_btn">Добавить</a>
    </div>
@endsection


@section('content')

    <form id="cms_data_form" action="{{ route('cms.editors.save', [$id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="content__sticky">
            <div>            
                <h2 class="content__title title-big">
                    <a href="{{ route('cms.editors.home') }}">Редакторы</a>
                </h2>
                <a class="content__button-add" href="{{ route('cms.editors.item', ['add']) }}">+</a>
            </div>
            <button class="button-icon button-icon--save">
                Сохранить
            </button>
        </div>

        <div class="content__background">


            <div class="edit__item">
                <label class="edit__label label">
                    Имя *
                </label>
                <input class="input" type="text" name="name" value="{{ isset($item['name']) ? $item['name'] : '' }}" required>
            </div>


            <div class="edit__item">
                <label class="edit__label label">
                    Электронная почта *
                </label>
                <input class="input" type="email" name="email" value="{{ isset($item['email']) ? $item['email'] : '' }}" required>
            </div>

            <div class="edit__item">
                <table class="table">
                    <tr class="table__row table__header-row">
                        <th class="table__header table__header--center label">
                            Модуль
                        </th>
                        <th class="table__header table__header--center label">
                            Просмотр
                        </th>
                        <th class="table__header table__header--center label">
                            Добавление
                        </th>
                        <th class="table__header table__header--center label">
                            Редактирование
                        </th>
                        <th class="table__header table__header--center label">
                            Удаление
                        </th>
                    </tr>
                @foreach(Config::get('cms.menu') as $menuBlock)
                    @if(!isset($menuBlock['admin_only']) || !$menuBlock['admin_only'])
                        <tr class="table__row">
                            <td class="table__td table__td--center" colspan="4">
                                {{ $menuBlock['name'] }}
                            </td>
                        </tr>

                        @if(is_array($menuBlock['modules']))
                            @foreach($menuBlock['modules'] as $moduleSlug)
                                @if(!isset(Config::get('cms.modules')[$moduleSlug]['admin_only']) || !Config::get('cms.modules')[$moduleSlug]['admin_only'])
                                    <tr class="table__row">
                                        <td class="table__td">
                                            {{ Config::get('cms.modules')[$moduleSlug]['name'] }}
                                        </td>
                                        <td class="table__td table__td--center">
                                            <input type="checkbox" name="{{ $moduleSlug }}_view" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['view']) ? 'checked' : '' }}>
                                        </td>
                                        <td class="table__td table__td--center">
                                            <input type="checkbox" name="{{ $moduleSlug }}_add" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['add']) ? 'checked' : '' }}>
                                        </td>
                                        <td class="table__td table__td--center">
                                            <input type="checkbox" name="{{ $moduleSlug }}_edit" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['edit']) ? 'checked' : '' }}>
                                        </td>
                                        <td class="table__td table__td--center">
                                            <input type="checkbox" name="{{ $moduleSlug }}_delete" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['delete']) ? 'checked' : '' }}>
                                        </td>
                                    </tr> 
                                @endif                                    
                            @endforeach
                        @else
                            @if(!isset(Config::get('cms.modules')[$menuBlock['modules']]['admin_only']) || !Config::get('cms.modules')[$menuBlock['modules']]['admin_only'])
                                <tr>
                                    <th>
                                        {{ Config::get('cms.modules')[$menuBlock['modules']]['name'] }}
                                    </th>
                                    <th>
                                        <input type="checkbox" name="{{ $menuBlock['modules'] }}_view" value="1" {{ $item && in_array($menuBlock['modules'], $item->cms_modules['view']) ? 'checked' : '' }}>
                                    </th>
                                    <th>
                                        <input type="checkbox" name="{{ $menuBlock['modules'] }}_add" value="1" {{ $item && in_array($menuBlock['modules'], $item->cms_modules['add']) ? 'checked' : '' }}>
                                    </th>
                                    <th>
                                        <input type="checkbox" name="{{ $menuBlock['modules'] }}_edit" value="1" {{ $item && in_array($menuBlock['modules'], $item->cms_modules['edit']) ? 'checked' : '' }}>
                                    </th>
                                    <th>
                                        <input type="checkbox" name="{{ $menuBlock['modules'] }}_delete" value="1" {{ $item && in_array($menuBlock['modules'], $item->cms_modules['delete']) ? 'checked' : '' }}>
                                    </th>
                                </tr> 
                            @endif                          
                        @endif
                    @endif
                @endforeach
                {{--
                                        @foreach(Config::get('cms.modules') as $moduleSlug => $module)
                                            @if(!isset($module['admin_only']) || !$module['admin_only'])
                                                <tr>
                                                    <th>
                                                    {{ $module['name'] }}
                                                    </th>
                                                    <th>
                                                        <input type="checkbox" name="{{ $moduleSlug }}_view" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['view']) ? 'checked' : '' }}>
                                                    </th>
                                                    <th>
                                                        <input type="checkbox" name="{{ $moduleSlug }}_add" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['add']) ? 'checked' : '' }}>
                                                    </th>
                                                    <th>
                                                        <input type="checkbox" name="{{ $moduleSlug }}_edit" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['edit']) ? 'checked' : '' }}>
                                                    </th>
                                                    <th>
                                                        <input type="checkbox" name="{{ $moduleSlug }}_delete" value="1" {{ $item && in_array($moduleSlug, $item->cms_modules['delete']) ? 'checked' : '' }}>
                                                    </th>
                                                </tr>                        
                                            @endif
                                        @endforeach
                --}}                        
                </table>
            </div>

            <fieldset class="edit__password-field">
                <div class="edit__item">
                    <label class="edit__label label">
                        Пароль
                    </label>
                    <input class="input" type="password" name="password" id="password" value="" autocomplete="off">
                </div>
                <div class="edit__item">
                    <label class="edit__label label">
                        Подтверждение пароля
                    </label>
                    <input class="input" type="password" name="password_confirm" id="password_confirm" value="" autocomplete="off">
                </div>
                <div class="" id="password_validation_err" style="display: none;">
                    Пароль и подтверждение не совпадают
                </div>
            </fieldset>
            

        
            <p><br><br><br><br><br><br><br><br><br></p>
        </div>
    </form>


@endsection

@push('scripts')
    <script src="{{ asset('/cms/scripts/editors.js') }}?v={{ rand(0, 99999) }}"></script>
@endpush


