@extends('layouts.app')

@section('title', 'Comments - Pascal Sommer Photography')

@section('content')

	<div class="container">
		<h1>Comments</h1>

		@include('comments.list')
	</div>

@endsection