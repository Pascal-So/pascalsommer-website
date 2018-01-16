<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name='keywords' content='photography, blog, photos, pictures, camera'>
    <meta name='description' content='A photography blog by Pascal Sommer'>
    <meta name='subject' content='Photography'>
    <meta name='copyright' content='Pascal Sommer'>
    <meta name='language' content='EN'>
    <meta name='robots' content='index,follow'>
    <meta name='author' content='Pascal Sommer'>
    <meta name='revisit-after' content='7 days'>
    <meta name='target' content='all'>
    <meta name='HandheldFriendly' content='True'>
    <meta name='MobileOptimized' content='320'>
    <meta name='medium' content='blog'>

    <meta property="og:title" content="Pascal Sommer Photography">
    <meta property="og:description" content="A photography blog by Pascal Sommer">
    <meta property="og:image" content="{{ asset('img/pascalsommerphotography.jpg') }}">
    <meta property="og:url" content="{{ route('home') }}">

    <meta name="twitter:title" content="Pascal Sommer Photography">
    <meta name="twitter:description" content="A photography blog by Pascal Sommer">
    <meta name="twitter:image" content="{{ asset('img/pascalsommerphotography.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    <title>Pascal Sommer</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Mono&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pascal.css') }}">

    @auth
        <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    @endauth

</head>
<body>

@auth
    <nav class="alignright admin-nav">
        <a class="{{ Route::is('home') ? 'nav-link-active' : '' }}" href="{{ route('home') }}">Home</a>
        <a class="{{ Route::is('uploadForm') ? 'nav-link-active' : '' }}" href="{{ route('uploadForm') }}">Upload</a>
        <a class="{{ Route::is('staging') ? 'nav-link-active' : '' }}" href="{{ route('staging') }}">Staging</a>
        <a class="{{ Route::is('createPost') ? 'nav-link-active' : '' }}" href="{{ route('createPost') }}">New Post</a>
        <a class="{{ Route::is('posts') ? 'nav-link-active' : '' }}" href="{{ route('posts') }}">All Posts</a>
        <a class="{{ Route::is('photos') ? 'nav-link-active' : '' }}" href="{{ route('photos') }}">All Photos</a>
        <a class="{{ Route::is('tags') ? 'nav-link-active' : '' }}" href="{{ route('tags') }}">Tags</a>
        <a class="{{ Route::is('comments') ? 'nav-link-active' : '' }}" href="{{ route('comments') }}">Comments</a>
        <span>&nbsp;</span>
        <a href="{{ route('logout') }}">Logout</a>
    </nav>
@endauth



@yield('content')
<br><br><br><br>
<footer class="alignright">
    Copyright &copy;2013-{{ date('Y') }} Pascal Sommer
    <br>
    All Rights Reserved
</footer>

</body>
</html>