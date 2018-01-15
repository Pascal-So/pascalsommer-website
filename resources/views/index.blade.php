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

<br>
<br><br>

@foreach($posts as $post)

    <h2>{{ $post->formatTitle() }}</h2>

    @foreach($post->photos as $photo)
        <a href="{{ route('viewPhoto', compact('photo')) }}" class="photolink">
            <img class="photo" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}" title="{{ $photo->alttext() }}">
        </a>
        <br>
    @endforeach

@endforeach

@include('layouts.pagination_nav', ['items' => $posts])

<br><br><br>

<div>
    <a class="btn" href="{{ route('about') }}">About</a>
    <span>&nbsp;</span>
    <a class="btn" href="{{ route('filtered') }}">Filter by Tags</a>
    <span>&nbsp;</span>
    @guest
        <a class="btn" href="{{ route('login') }}">Login</a>
    @endguest
</div>

@endsection
