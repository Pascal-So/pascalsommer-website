<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pascal Sommer</title>

    <link href="https://fonts.googleapis.com/css?family=Cutive+Mono" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Mono&amp;subset=cyrillic" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/visitor.css') }}">
</head>
<body>

@yield('content')
<br><br><br>
<footer>
    © Pascal Sommer 2018 <br>
    <a href="{{ route('login') }}">login</a>
</footer>

</body>
</html>