<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('layouts.meta')

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
        <a class="{{ Route::is('posts') ? 'nav-link-active' : '' }}" href="{{ route('posts') }}">Posts</a>
        <a class="{{ Route::is('tags') ? 'nav-link-active' : '' }}" href="{{ route('tags') }}">Tags</a>
        <a class="{{ Route::is('comments') ? 'nav-link-active' : '' }}" href="{{ route('comments') }}">Comments</a>
        <span>&nbsp;</span>
        <a href="{{ route('logout') }}">Logout</a>
    </nav>
@endauth

@yield('content')
<br><br><br><br>
<footer class="alignright">
    <p>Copyright &copy;2013-{{ date('Y') }} Pascal Sommer
    <br>
    All Rights Reserved</p>
</footer>

</body>
</html>