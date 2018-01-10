@extends('layouts.pascal')

@section('content')


@include('comment.list', ['comments' => $comments])


@endsection
