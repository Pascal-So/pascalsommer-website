@extends('layouts.pascal')

@section('content')

<br><br>
<h1>Pascal Sommer</h1>

<p>
    <a title="Soundcloud" href="https://soundcloud.com/pascal-sommer" class="social-media-link">@include('icons.soundcloud')</a>
    <a title="Twitter" href="https://twitter.com/sommerpascal" class="social-media-link">@include('icons.twitter')</a>
    <a title="Github" href="https://github.com/pascal-so" class="social-media-link">@include('icons.github')</a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch" class="social-media-link">@include('icons.medium')</a>
    <a title="Google Play" href="https://play.google.com/store/apps/developer?id=Pascal+Sommer" class="social-media-link">@include('icons.googleplay')</a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies" class="social-media-link">@include('icons.youtube')</a>
    <a title="RSS feed - {{ config('feed.feeds.posts.title') }}" type="application/atom+xml" href="{{ asset('feed') }}" class="social-media-link">@include('icons.rss')</a>
</p>

<br>
<br>
@include('layouts.pagination_nav', ['items' => $posts, 'from_page_two' => true])
<br>

@foreach($posts as $post)

    <h2 id="post_{{ $post->titleSlug() }}"><a title="permalink" href="{{ $post->permalink() }}">#</a> {{ $post->formatTitle() }}</h2>

    @foreach($post->photos()->blogOrdered()->get() as $photo)
        <a href="{{ $photo->url() }}" class="photolink">
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
