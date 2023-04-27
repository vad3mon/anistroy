<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CMS</title>
        <script type="module" crossorigin src="{{ asset('/cms/scripts/select.js') }}"></script>
        <link rel="stylesheet" href="/cms/styles/index.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <main class="main">
            @include('cms.parts.navigation')
            <section class="content">
                @include('cms.parts.editor-profile')
                <section class="content__container container">
                    @yield('content')
                </section>
            </section>
        </main>

        @stack('scripts')
    </body>
</html>