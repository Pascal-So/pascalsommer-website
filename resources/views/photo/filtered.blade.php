@extends('layouts.pascal')

@section('content')

<br><br>
<a href="{{ route('home') }}" class="stealth-link"><h1>Pascal Sommer</h1></a>

<br>

<h2 style="display: inline-block;">Tags: </h2>

@if($tags_arr->isEmpty())
    <span>no tags selected</span>
@endif
@foreach($tags_arr as $tag)
    @php
        $tags_str = implode(',', $tags_arr->diff([$tag])->toArray());
        
        $link = route('filtered', ['tags' => $tags_str]);
    @endphp
    <span class="tag" title="Click to remove a tag">-&nbsp;<a href="{{ $link }}">{{ $tag }}</a></span>
@endforeach

<br><br>
@if($unused_tags_arr->isNotEmpty())
    <span>Other tags: </span>
@endif
@foreach($unused_tags_arr as $tag)
    @php
        $tags_str = implode(',', collect($tags_arr)->push($tag)->sort()->toArray());
        $link = route('filtered', ['tags' => $tags_str]);
    @endphp
    <span class="tag" title="Click to add a tag">+&nbsp;<a href="{{ $link }}">{{ $tag }}</a></span>
@endforeach

<br>
<br>
<a class="btn" href="{{ route('home') }}" title="Home">Return to overview</a>
<br>
<br>

@if($photos->isEmpty())
    <br><br>
    <p>No results. Try removing some filters.</p>
@endif

@foreach($photos as $photo)
    <a href="{{ route('viewPhoto', compact('photo')) }}" class="photolink">
        <img class="photo" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}" title="{{ $photo->alttext() }}">
    </a>
    <br>
@endforeach

@include('layouts.pagination_nav', ['items' => $photos])

@endsection
