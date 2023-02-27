@extends('layout.site', ['title' => $page->name ])

@section('content')
    <section class="about">
        <h2>{{ $page->name }}</h2>
        <p>{{ $page->content }}</p>
    </section>
@endsection
