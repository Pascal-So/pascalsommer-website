@extends('layouts.pascal')

@section('content')

<br><br>
<h1>Pascal Sommer</h1>

@include('layouts.social-links')

<br><br>

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
