@extends('cms.layout')


@section('header')
    <div class="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Config::get('cms.modules')[$module]['name'] }}
        </h2>
        @if($request->input('parent'))
            <a href="{{ route('cms.models.item', [$module, 'add', 'with_parent' => $request->input('parent')]) }}" class="add_btn">Добавить</a>
        @else
            <a href="{{ route('cms.models.item', [$module, 'add']) }}" class="add_btn">Добавить</a>
        @endif
    </div>
@endsection


@section('content')


    <div class="content__row">
        <h2 class="content__title title-big">{{ Config::get('cms.modules')[$module]['name'] }}</h2>
        @if($request->input('parent'))
            <a class="content__button-add" href="{{ route('cms.models.item', [$module, 'add', 'with_parent' => $request->input('parent')]) }}">+</a>
        @else
            <a class="content__button-add" href="{{ route('cms.models.item', [$module, 'add']) }}">+</a>
        @endif        
    </div>

    @if(count($editorFilters))
        <div class="content__background">
            <form class="filters" method="get">
                <section class="content__filter filter">
                    @forelse($editorFilters as $field => $filedData)
                        @switch($filedData['type'])    
                            @case('enum')
                                <div class="filter__item">
                                    <label class="filter__label label">{{ $filedData['title'] }}</label>
                                    <select class="select" name="{{ $field }}">
                                        <option value="">все</option>
                                        @foreach($filedData['values'] as $val => $valName)
                                            <option value="{{ $val }}" {{ ($request->has($field) && $request->input($field) == $val) ? 'selected' : '' }}>{{ $valName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @break

                            @case('set')
                                <div class="filter__item">
                                    <label class="filter__label label">{{ $filedData['title'] }}</label>
                                    <select class="select" name="{{ $field }}">
                                        <option value="">все</option>
                                        @foreach($additionalData[$field] as $val)
                                            <option value="{{ $val->id }}" {{ ($request->has($field) && $request->input($field) == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @break

                            @case('search')
                                <div class="filter__item">
                                    <label class="filter__label label">
                                        Поиск
                                    </label>
                                    <input class="filter__input input" type="text" name="search" placeholder="{{ $filedData['title'] }}" value="{{ $request->input('search') }}">
                                </div>
                            @break
                        @endswitch
                    @empty
                    @endforelse

                    <button class="button" type="submit">Фильтруем</button>
                </section>
            </form>
        </div>
    @endif
    






    <div class="content__background">
        <div class="table-wrapper">
                    
            <table class="table {{ isset($editorSettings['has_position']) && $editorSettings['has_position'] ? 'draggable-table' : '' }}" data-pos-route="{{ route('cms.models.position', [$module]) }}" data-list-table="">
                <thead>
                    @if($goUpId !== false)
                        <tr class="table__row">
                            <td colspan="100%">
                                <a class="table__prev-btn" href="{{ route('cms.models.home', [$module, 'parent' => $goUpId]) }}">Назад</a>
                            </td>
                        </tr>                    
                    @endif                    
                    <tr class="table__row table__header-row">
                        @if($parented)
                            <th class="table__header label"></th>
                        @endif                           
                        @if($editorSettings['has_published'])
                            <th class="table__header label"></th>
                        @endif

                        @forelse($editorTableFields as $filed => $filedData)
                            <th class="table__header label">{{ $filedData['title'] }}</th>
                        @empty
                        @endforelse
                        <th class="table__header label"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $item)
                        <tr data-id="{{ $item->id }}" class="@if($editorSettings['has_published']) published_{{ $item->published }} @endif">
                            @if($parented)
                                <td class="table__folder">
                                    <a class="table__folder-btn" href="{{ route('cms.models.home', [$module, 'parent' => $item->id]) }}">
                                        <img src="{{ asset('/cms/icons/folder-dark.svg') }}" alt="">
                                    </a>
                                </td>
                            @endif                                    
                            @if($editorSettings['has_published'])
                                <td class="table__cell"></td>
                            @endif

                            @forelse($editorTableFields as $field => $filedData)
                                <td class="table__cell">
                                    <a href="{{ route('cms.models.item', [$module, $item->id]) }}">
                                        @switch($filedData['type'])
                                            @case('has_data')
                                                {{ $item[$field] ? '+' : '' }}
                                            @break

                                            @case('one_by_id')
                                                @foreach($additionalData[$field] as $key => $dt)
                                                    @if($dt->id == $item[$field])
                                                        {{ $dt->name }}
                                                    @endif
                                                @endforeach                                                        
                                            @break

                                            @case('image')
                                                @if($item[$field])
                                                    <img src="{{ asset('storage/images/cms_thumbnails/' . $item[$field]) }}" alt="">
                                                @endif
                                            @break

                                            @default
                                                {{ $item[$field] }}
                                            @break
                                        @endswitch
                                    </a>
                                </td>
                            @empty
                            @endforelse

                            @if($editorSettings['deletable'])
                                <td class="table__cell">
                                    <a class="table__delete-btn" data-route="{{ route('cms.models.delete', [$module, $item->id]) }}" data-confirm="Точно удалить?" data-delete=""></a>
                                </td>
                            @endif
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{-- $list->withQueryString()->links() --}}
        </div>
        @include('cms.parts.pagination', ['list' => $list])
    </div>
@endsection



@push('scripts')
    <link href="{{ asset('/cms/scripts/table-pos/style.css') }}" rel="stylesheet">
    <script src="{{ asset('/cms/scripts/table-pos/script.js') }}"></script>

    <script src="{{ asset('/cms/scripts/scripts.js') }}"></script>
@endpush