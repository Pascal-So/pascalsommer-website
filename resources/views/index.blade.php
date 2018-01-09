@extends('layouts.visitor')

@section('content')

<h1>Pascal Sommer</h1>

<p>
    <a title="Twitter" href="https://twitter.com/sommerpascal"><img class="icon" src="{{ asset('img/icons/twitter.svg') }}"></a>
    <a title="Github" href="https://github.com/pascal-so"><img class="icon" src="{{ asset('img/icons/github.svg') }}"></a>
    <a title="Medium" href="https://medium.com/@pascal.sommer.ch"><img class="icon" src="{{ asset('img/icons/medium-m.svg') }}"></a>
    <a title="Youtube" href="https://youtube.com/pascalsommermovies"><img class="icon" src="{{ asset('img/icons/youtube.svg') }}"></a>
</p>

<br><br><br>

@foreach($posts as $post)

    <h2>{{ $post->title }} - {{ $post->date }}</h2>

    @foreach($post->photos as $photo)
        <a href="{{ route('viewphoto', ['photo' => $photo]) }}" class="photolink">
            <img class="photo" src="{{ asset($photo->path) }}">
        </a>
        <br>
    @endforeach

@endforeach

@if($posts->hasMorePages() || $posts->currentPage() != 1)
	<p>
		@if($posts->currentPage() > 1)
			<a href="{{ $posts->previousPageUrl() }}"><img class="arrow-icon-small" src="{{ asset('img/icons/larrow.svg') }}"></a>
		@else
			<span class="arrow-icon-small-placeholder"></span>
		@endif
		
		{{ $posts->currentPage() }}

		@if($posts->hasMorePages())
			<a href="{{ $posts->nextPageUrl() }}"><img class="arrow-icon-small" src="{{ asset('img/icons/rarrow.svg') }}"></a>
		@else
			<span class="arrow-icon-small-placeholder"></span>
		@endif
	</p>
@endif

@endsection
