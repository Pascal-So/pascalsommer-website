@extends('layouts.pascal')

@section('content')

<h1>Comments</h1>

@include('comment.list', ['comments' => $comments, 'admin_overview' => true])


@endsection
