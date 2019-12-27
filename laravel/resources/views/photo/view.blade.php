@extends('layouts.pascal')

@section('social_image', asset($photo->path))

@section('social_description', $photo->description ?: config('constants.page_description'))

@section('content')

@if($photo->isPublic())
    <h2><a title="photo permalink" href="{{ $photo->url() }}">#</a>
        <a class="stealth-link"
        href="{{ $photo->post->permalink() }}">
        {{ $photo->post->formattitle() }}
    </a></h2>
@else
    <h2><a class="stealth-link" href="{{ route('home') }}">
        Unpublished Photo
    </a></h2>
@endif

<div class="flex-center-row">
    @if($photo->prevPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a id="link-left" href="{{ $photo->prevPhoto()->url() }}"><img class="arrow-icon" src="{{ asset('img/icons/larrow.svg') }}"></a>
    @endif
    <a href="{{ asset($photo->path) }}" target="blank">
        <img id="photo" class="photo-large" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}">
    </a>
    @if($photo->nextPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a id="link-right" href="{{ $photo->nextPhoto()->url() }}"><img class="arrow-icon" src="{{ asset('img/icons/rarrow.svg') }}"></a>
    @endif
</div>
<script type="text/javascript" src="{{ asset('js/arrowNavigate.js')}}" defer></script>

<div class="hidden" id="photo_width">{{$photo->width()}}</div>
<div class="hidden" id="photo_height">{{$photo->height()}}</div>
<script type="text/javascript" src="{{ asset('js/setPhotoDimensions.js') }}" async></script>

<br>

@foreach($photo->tags as $tag)
    <a class="tag" href="{{ route('filtered', ['tags' => $tag->name]) }}">{{ $tag->name }}</a>
@endforeach

<ul>
    @if($photo->description != '')
        <li class="comment">
            <p class="photo-description">Photo {{ $photo->id }}: {!! $photo->descriptionHTML() !!}</p>
        </li>
        <br>
    @endif

    @php
    $comments = $photo->comments->sortByDesc('created_at');
    @endphp

    @forelse($comments as $comment)
        <li class="comment" id="comment_{{ $comment->id }}">
            <h2>
                <a href="{{ $comment->photo->url() }}#comment_{{ $comment->id }}">
                    {{ $comment->name }}
                </a>
            </h2>

            <p>{{ $comment->created_at->format('Y-m-d') }}</p>
            <p>{!! $comment->commentHTML() !!}</p>

            @auth
                <a href="{{ route('deleteComment', compact('comment')) }}"
                    class="btn btn_comment_delete"
                    data-deletable-comment
                    data-name="{{ str_replace('"', "'", $comment->name) }}"
                    data-comment="{{ str_replace('"', "'", $comment->comment) }}"
                    >
                    Delete
                </a>
            @endauth
        </li>
        <br>
    @empty
        <li class="comment" id="comment_none">
            <p class="photo-description">No comments yet</p>
        </li>
        <br>
    @endforelse

    <li class="comment" id="comment_form">
        @if($photo->isPublic())
            @include('comment.form')
        @endif
    </li>
</ul>

<br><br>

<a class="btn" href="{{ route('home') }}?page={{ $photo->getPaginationPage() }}#photo_{{ $photo->id }}" title="Home">
    Return to Overview
</a>
<a class="btn" href="{{ route('randomPhoto') }}" title="Show a random photo">
    Random Photo
</a>
@auth
    <a class="btn" href="{{ route('editPhoto', compact('photo')) }}">
        Edit Photo
    </a>
@endauth

<br>


@endsection
