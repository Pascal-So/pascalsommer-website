@extends('layouts.pascal')

@section('content')

<h1>Gallery</h1>

<br><br><br>

@foreach($photos as $photo)
    <a href="{{ route('viewPhoto', compact('photo')) }}"><img class="photo-gallery" src="{{ asset($photo->path) }}"></a>
@endforeach

@include('layouts.pagination_nav', ['items' => $photos])

@endsection
