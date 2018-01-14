@extends('layouts.pascal')

@section('content')

<h2>{{ $photo->post->formattitle() }}</h2>

<div class="flex-center-row">
    @if($photo->prevPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a href="{{ route('viewPhoto', ['photo' => $photo->prevPhoto()]) }}"><img class="arrow-icon" src="{{ asset('img/icons/larrow.svg') }}"></a>
    @endif
    <img class="photo-large" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}">
    @if($photo->nextPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a href="{{ route('viewPhoto', ['photo' => $photo->nextPhoto()]) }}"><img class="arrow-icon" src="{{ asset('img/icons/rarrow.svg') }}"></a>
    @endif
</div>
<br>

<span>Tags:</span>
@foreach($photo->tags as $tag)
    <a href="{{ route('filtered', ['tags' => $tag->name]) }}">{{ $tag->name }}</a>
@endforeach

<p>{{ $photo->description }}</p>

<br>
<br>

@include('comment.list', ['comments' => $photo->comments->sortByDesc('created_at')])

<br>
<br>

@include('comment.form')


@endsection
