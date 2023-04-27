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

    <div class="content__row">
        <h2 class="content__title title-big">Редакторы</h2>
        <a class="content__button-add" href="{{ route('cms.editors.item', ['add']) }}">+</a>
    </div>


    <div class="content__background">
        <div class="table-wrapper">
                    
            <table class="table" data-list-table="">
                <thead>
                    <tr class="table__row table__header-row">
                        <th class="table__header label">Имя</th>
                        <th class="table__header label">Электронная почта</th>
                        <th class="table__header label"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $item)
                        <tr class="table__row" data-id="{{ $item->id }}">
                            <td class="table__cell">
                                <a href="{{ route('cms.editors.item', [$item->id]) }}">
                                    {{ $item->name }}
                                </a>
                            </td>

                            <td class="table__cell">
                                <a href="{{ route('cms.editors.item', [$item->id]) }}">
                                    {{ $item->email }}
                                </a>
                            </td class="table__cell">

                            <td class="table__cell">
                                <a class="table__delete-btn delete" data-route="{{ route('cms.editors.delete', [$item->id]) }}" data-confirm="Точно удалить?" data-delete=""></a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection


@push('scripts')
    <script src="{{ asset('/cms/scripts/scripts.js') }}"></script>
@endpush