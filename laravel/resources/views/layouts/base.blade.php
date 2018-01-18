<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('layouts.meta')

    <title>Pascal Sommer</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Mono&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pascal.css') }}">

    @yield('head')

    @auth
        <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    @endauth

</head>
<body>

@include('layouts.admin_nav')

@yield('content-base')


</body>
</html>