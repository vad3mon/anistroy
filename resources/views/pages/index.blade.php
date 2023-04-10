@extends('layout.site', ['title' => $page->name ])

@section('content')
    <section class="about">
        <h1>{{ $page->name }}</h1>
        {!! $page->content !!}
    </section>
@endsection
