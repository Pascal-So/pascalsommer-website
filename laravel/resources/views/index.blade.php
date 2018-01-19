@extends('layouts.pascal')

@section('content')

<br><br>
<h1>Pascal Sommer</h1>

<p>
    <a title="Twitter" href="https://twitter.com/sommerpascal"><img alt="Social Media Icon Twitter" class="icon" src="{{ asset('img/icons/twitter.svg') }}"></a>
    <a title="Github" href="https://github.com/pascal-so"><img alt="Icon Github" class="icon" src="{{ asset('img/icons/github.svg') }}"></a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch"><img alt="Social Media Icon Medium" class="icon" src="{{ asset('img/icons/medium-m.svg') }}"></a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies"><img alt="Social Media Icon Youtube" class="icon" src="{{ asset('img/icons/youtube.svg') }}"></a>
</p>

<br>
<br>
@include('layouts.pagination_nav', ['items' => $posts, 'from_page_two' => true])
<br>

@foreach($posts as $post)

    <h2 id="post_{{ $post->titleSlug() }}">{{ $post->formatTitle() }}</h2>

    @foreach($post->photos()->blogOrdered()->get() as $photo)
        <a href="{{ route('viewPhoto', compact('photo')) }}" class="photolink">
            <img class="photo" 
                src="{{ asset($photo->path) }}" 
                alt="{{ $photo->alttext() }}" 
                title="{{ $photo->alttext() }}" 
                id="photo_{{ $photo->id }}">
        </a>
        <br>
    @endforeach

@endforeach

@include('layouts.pagination_nav', ['items' => $posts, 'from_page_two' => false])

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
