@extends('layouts.app')

@section('title', 'Admin - Pascal Sommer Photography')

@section('content')

	<div class="container">
		<h1>Admin area</h1>

		<div class="btn-group">
			<a href="{{ action('PhotoController@upload') }}" class="btn btn-default">Upload photos</a>
			<a href="{{ action('PhotoController@index') }}" class="btn btn-default">All photos</a>
			<a href="{{ action('CommentController@index') }}" class="btn btn-default">Comments</a>
			<a href="" class="btn btn-default">Upload photos</a>
			<a href="" class="btn btn-default">Upload photos</a>
		</div>

		<h2>Stats</h2>

	</div>

@endsection