<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hub71') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:title" content="Empowering today. Impacting tomorrow.">
    <meta property="og:site_name" content="Hub71 Impact">
    <meta property="og:url" content="https://vcmeets.hub71impact.com">
    <meta property="og:description" content="VC Meets @ Hub71 Impact. Empowering today. Impacting tomorrow.">
    <meta property="og:type" content=object>
    <meta property="og:image" content="{{asset('images/social_share.jpg')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('body-classes')">
    <div id="app">
        <main class="@yield('main-classes')">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
