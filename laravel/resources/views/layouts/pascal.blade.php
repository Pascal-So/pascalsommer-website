@extends('layouts.base')

@section('content')

@yield('content')

<br><br><br><br>
<footer class="alignright">
    <p>Copyright &copy;2013-{{ date('Y') }} Pascal Sommer
    <br>
    All Rights Reserved</p>
</footer>

@endsection