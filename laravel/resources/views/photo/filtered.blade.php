@extends('layouts.pascal')

@section('title', 'Tag Filter - Pascal Sommer')

@section('content')

<br><br>
<a href="{{ route('home') }}" class="stealth-link"><h1>Pascal Sommer</h1></a>

<br>

<h2 id="start-content">Filter by Tags</h2>

@foreach($tags as $tag)
    @if($tags_arr->contains($tag->name))
        @php
            $tags_str = implode(',', $tags_arr->diff([$tag->name])->push('!' . $tag->name)->toArray());
            $link = route('filtered', ['tags' => $tags_str]);
        @endphp
        <a class="tag tag-active" title="Click to exclude tag" href="{{ $link }}">{{ $tag->name }}</a>
    @elseif ($tags_arr->contains('!' . $tag->name))
        @php
            $tags_str = implode(',', $tags_arr->diff(['!'. $tag->name])->toArray());
            $link = route('filtered', ['tags' => $tags_str]);
        @endphp
        <a class="tag tag-active-not" title="Click to remove tag" href="{{ $link }}">!{{ $tag->name }}</a>
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
@else
    <p><a href="{{ route('filtered') }}" data-shortcutkeycode="67" title="(shortcut: c)">clear tags</a></p>
@endif

@include('layouts.pagination_nav', ['items' => $photos, 'from_page_two' => true])
<br>

@if($photos->isEmpty())
    <br><br>
    <p>No results. Try removing some filters.</p>
@endif

@foreach($photos as $photo)
    <a href="{{ $photo->url() }}" class="photolink">
        <img class="photo" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}" title="{{ $photo->titletext() }}">
    </a>
    <br>
@endforeach

@include('layouts.pagination_nav', ['items' => $photos])

<br><br>

<a class="btn" data-shortcutkeycode="72" href="{{ route('home') }}" title="Go back to the list of all photos (shortcut: h)">
    Return to Overview
</a>
<a class="btn" href="#">Scroll to top</a>

@endsection
