<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/ico" sizes="16x16" href="../img/heart.ico">
        <!--<title>{{ config('app.name', 'Laravel') }}</title>
         Fonts
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
         Scripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])-->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        <title>{{ $title }}</title>

    </head>
    <body>
            <x-header.header />
                <main class="contex">
                    <div class="wrapper">
                        {{ $slot }}
                    </div>
                </main>
            <x-footer.footer />

    </body>
</html>
