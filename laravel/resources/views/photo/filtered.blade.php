@extends('layouts.pascal')

@section('content')

<br><br>
<a href="{{ route('home') }}" class="stealth-link"><h1>Pascal Sommer</h1></a>

<br>

<h2>Filter by Tags</h2>

@foreach($tags as $tag)
    @if($tags_arr->contains($tag->name))
        @php
            $tags_str = implode(',', $tags_arr->diff([$tag->name])->toArray());
            $link = route('filtered', ['tags' => $tags_str]);
        @endphp
        <a class="tag-active" title="Click to remove tag" href="{{ $link }}">{{ $tag->name }}</a>
    @else
        @php
            $tags_str = implode(',', collect($tags_arr)->push($tag->name)->sort()->toArray());
            $link = route('filtered', ['tags' => $tags_str]);
        @endphp
        <a class="tag" title="Click to add tag" href="{{ $link }}">{{ $tag->name }}</a>
    @endif
@endforeach
<br>
<br>
@if($tags_arr->isEmpty())
    <p>no tags selected</p>
@endif


<br>
@include('layouts.pagination_nav', ['items' => $photos, 'from_page_two' => true])
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

<br><br>

<a class="btn" href="{{ route('home') }}" title="Home">Return to overview</a>
<a  class="btn" href="#">Scroll to top</a>

@endsection
