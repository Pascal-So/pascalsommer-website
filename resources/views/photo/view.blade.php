@extends('layouts.visitor')

@section('content')

<h2>{{ $photo->post->formattitle() }}</h2>

<div class="flex-center-row">
	@if($photo->prevPhoto() == null)
		<div class="arrow-icon-placeholder"></div>
	@else
		<a href="{{ route('viewphoto', ['photo' => $photo->prevPhoto()]) }}"><img class="arrow-icon" src="{{ asset('img/icons/larrow.svg') }}"></a>
	@endif
	<img class="photo-large" src="{{ asset($photo->path) }}">
	@if($photo->nextPhoto() == null)
		<div class="arrow-icon-placeholder"></div>
	@else
		<a href="{{ route('viewphoto', ['photo' => $photo->nextPhoto()]) }}"><img class="arrow-icon" src="{{ asset('img/icons/rarrow.svg') }}"></a>
	@endif
</div>
<br>


<p>{{ $photo->description }}</p>



@endsection
