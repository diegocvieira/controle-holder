<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Controle Holder</title>

        <base href="{{ url('/') }}">
        <link rel="canonical" href="{{ $metaCanonical ?? url()->current() }}" />
    	<!-- <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"> -->
    	<meta name="theme-color" content="#1f212e">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/sass/app.scss') }}">
    </head>
    <body>
        @yield('content')

        <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
    </body>
</html>
