@extends('layouts.pascal')

@section('content')

<h2>{{ implode(', ', $tags_arr) }}</h2>

@foreach($photos as $photo)
    <a href="{{ route('viewPhoto', compact('photo')) }}" class="photolink">
        <img class="photo" src="{{ asset($photo->path) }}" alt="{{ $photo->alttext() }}" title="{{ $photo->alttext() }}">
    </a>
    <br>
@endforeach

@include('layouts.pagination_nav', ['items' => $photos])

@endsection
