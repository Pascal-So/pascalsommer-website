@extends('layouts.pascal')

@section('content')

<h1>Gallery</h1>

<br><br><br>

@include('layouts.pagination_nav', ['items' => $photos, 'from_page_two' => true])
<br>
@foreach($photos as $photo)<a href="{{ route('viewPhoto', compact('photo')) }}"><img class="photo-gallery" src="{{ asset($photo->path) }}"></a>@endforeach

<br>

@include('layouts.pagination_nav', ['items' => $photos])

@endsection
