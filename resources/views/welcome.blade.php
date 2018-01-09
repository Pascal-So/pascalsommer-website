@extends('layouts.app')

@section('content')

<h1>Pascal Sommer</h1>

<p>
    <a title="Twitter" href="https://twitter.com/sommerpascal"><img class="icon" src="{{ asset('img/icons/twitter.svg') }}"></a>
    <a title="Github" href="https://github.com/pascal-so"><img class="icon" src="{{ asset('img/icons/github.svg') }}"></a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch"><img class="icon" src="{{ asset('img/icons/medium-m.svg') }}"></a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies"><img class="icon" src="{{ asset('img/icons/youtube.svg') }}"></a>
</p>

<br><br><br>

<h2>Snow - 2017-12-27</h2>

<a href="{{ route('viewphoto', ['photo' => 1]) }}" class="photolink">
    <img class="photo" src="{{ asset('img/photos/pascalsommer_9.jpg') }}">
</a>
<br>


<a href="{{ route('viewphoto', ['photo' => 1]) }}" class="photolink">
    <img class="photo" src="{{ asset('img/photos/pascalsommer_8.jpg') }}">
</a>
<br>


<h2>Snow - 2017-12-27</h2>

<a href="{{ route('viewphoto', ['photo' => 1]) }}" class="photolink">
    <img class="photo" src="{{ asset('img/photos/pascalsommer_7.jpg') }}">
</a>
<br>


<style type="text/css">
    body{
        box-sizing: border-box;
        background-color: #121216;
        text-align: center;
        font-family: 'Cutive Mono', 'Courier New', Courier, monospace;
        font-weight: 400;
        color: #eee;
    }

    h1{
        font-size: 35px;
        margin: 45px 0 30px 0;
    }

    a{
        outline: none;
    }

    .icon{
        max-width: 20px;
        max-height: 20px;
        margin: 0 5px;
    }

    .photo{
        max-width: 900px;
        display: block;
    }

    .photolink{
        border: 1px solid #121216;
        display: inline-block;
        margin: 5px 0 50px;
    }

    .photolink:hover{
        border: 1px solid #eee;
    }
</style>

@endsection
