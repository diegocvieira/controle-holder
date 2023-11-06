<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ isset($metaTitle) ? $metaTitle . ' · ' : '' }} {{ config('app.name') }}</title>

        <base href="{{ url('/') }}">
        <link rel="canonical" href="{{ url()->current() }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    	<meta name="theme-color" content="#1e293b">

        <meta name="description" content="{{ config('app.seo_description') }}">
        <meta name="keywords" content="holder, portfolio, ativos, rebalancear, meta">

        <meta property="og:title" content="{{ isset($metaTitle) ? $metaTitle . ' · ' : '' }}{{ config('app.name') }}">
        <meta property="og:description" content="{{ config('app.seo_description') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ Vite::asset('resources/images/social-banner.png') }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ isset($metaTitle) ? $metaTitle . ' · ' : '' }}{{ config('app.name') }}">
        <meta name="twitter:description" content="{{ config('app.seo_description') }}">
        <meta name="twitter:image" content="{{ Vite::asset('resources/images/social-banner.png') }}">

        <meta name="msapplication-TileColor" content="#da532c">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ Vite::asset('resources/images/favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/images/favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/favicons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ Vite::asset('resources/images/favicons/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ Vite::asset('resources/images/favicons/safari-pinned-tab.svg') }}" color="#333333">

        <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/sass/app.scss') }}">
    </head>
    <body>
        <main class="main" id="{{ isset($page) ? $page . '-page' : '' }}">
            @isset($headerComponent)
                <header-component page="{{ $page ?? '' }}" is_logged="{{ auth()->check() }}"></header-component>
            @endisset

            @isset($loaderComponent)
                <loader-component ref="loader"></loader-component>
            @endisset

            @isset($modalComponent)
                <modal-component ref="modal"></modal-component>
            @endisset

            @isset($alertComponent)
                <alert-component ref="alert"></alert-component>
            @endisset

            @yield('template_content')
        </main>

        <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
    </body>
</html>
