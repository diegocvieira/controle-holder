<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Encontre as melhores ofertas e condições para comprar e vender passagens aéreas. O jeito mais seguro de viajar gastando menos ou lucrar com suas milhas.">
    <meta name="keywords" content="viagem, viajar, passagem, voo, oferta">

    <!-- <link rel="apple-touch-icon" sizes="57x57" href="{{ Vite::asset('resources/images/favicons/favicon@57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ Vite::asset('resources/images/favicons/favicon@60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ Vite::asset('resources/images/favicons/favicon@72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Vite::asset('resources/images/favicons/favicon@76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ Vite::asset('resources/images/favicons/favicon@114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ Vite::asset('resources/images/favicons/favicon@120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ Vite::asset('resources/images/favicons/favicon@144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ Vite::asset('resources/images/favicons/favicon@152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/images/favicons/favicon@180x180.png') }}">
    <link rel="icon shortcut" type="image/x-icon" href="{{ Vite::asset('resources/images/favicons/favicon.ico') }}"> -->

    <title>Tripwall</title>

    <!-- <link rel="preload" href="{{ Vite::asset('resources/files/DMSans.woff2') }}" as="font" type="font/woff2" crossorigin> -->

    @vite('resources/scss/app.scss')

    <meta property="og:site_name" content="Tripwall"/>
    <meta property="og:title" content="Tripwall">
    <meta property="og:description" content="Encontre as melhores ofertas e condições para comprar e vender passagens aéreas. O jeito mais seguro de viajar gastando menos ou lucrar com suas milhas.">
    <!-- <meta property="og:image" content="{{ Vite::asset('resources/images/cover.webp') }}"> -->
    <meta property="og:url" content="Tripwall">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tripwall">
    <meta name="twitter:description" content="Encontre as melhores ofertas e condições para comprar e vender passagens aéreas. O jeito mais seguro de viajar gastando menos ou lucrar com suas milhas.">
    <!-- <meta name="twitter:image" content="{{ Vite::asset('resources/images/cover.webp') }}"> -->

    <meta name="robots" content="index, follow">
</head>

<body>
    <div id="app"></div>

    @vite('resources/js/app.js')
</body>

</html>
