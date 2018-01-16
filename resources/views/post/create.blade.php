@extends('layouts.pascal')

@section('content')

<h1>New Post</h1>

@include('post.form', ['action' => route('storePost')])

<br><br><br>

@endsection
