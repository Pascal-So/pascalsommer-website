@extends('layouts.app')



@section('content')
	<div class="container">

		@include('includes.header')

		<a href="/login">login</a><br>
		<a href="/logout">logout</a><br>
		<a href="/photos">photos</a><br>
		<a href="/comments">comments</a><br>
	</div>

@endsection