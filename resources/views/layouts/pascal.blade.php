<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pascal Sommer</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Mono&amp;subset=cyrillic" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pascal.css') }}">
</head>
<body>

@auth
    <nav class="alignright admin-nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('uploadForm') }}">Upload</a>
        <a href="{{ route('staging') }}">Staging</a>
        <a href="{{ route('tags') }}">Tags</a>
        <a href="{{ route('comments') }}">Comments</a>
        <span>&nbsp;</span>
        <a href="{{ route('logout') }}">Logout</a>
    </nav>
@endauth

@yield('content')
<br><br><br>
<footer>
    © Pascal Sommer 2018 <br>
    @guest
        <a href="{{ route('login') }}">login</a>
    @endguest
</footer>

</body>
</html>