@extends('layouts.pascal')

@section('content')

<br><br>
<h1>Pascal Sommer</h1>

<p>
    <a title="Twitter" href="https://twitter.com/sommerpascal"><img class="icon" src="{{ asset('img/icons/twitter.svg') }}"></a>
    <a title="Github" href="https://github.com/pascal-so"><img class="icon" src="{{ asset('img/icons/github.svg') }}"></a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch"><img class="icon" src="{{ asset('img/icons/medium-m.svg') }}"></a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies"><img class="icon" src="{{ asset('img/icons/youtube.svg') }}"></a>
</p>

<br><br>

<p> Contact me: <a href="mailto:p@pascalsommer.ch">p@pas<span aria-hidden="true" class="hidden"> Pascal Sommer </span>calsommer.ch</a> </p>

<br>

<p> All images Copyright &copy;2013-{{ date('Y') }} Pascal Sommer </p>

<p> All Rights Reserved </p>

<br>

<p>Some other projects of mine: <a href="http://codelis.ch">codelis.ch</a></p>

<br><br><br>

<a class="btn" href="{{ route('home') }}">Back</a>

<p></p>

@endsection
