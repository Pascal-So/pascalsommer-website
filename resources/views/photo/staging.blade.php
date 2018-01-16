@extends('layouts.pascal')

@section('content')

<h1>Staging</h1>

@foreach($photos as $photo)
    <img src="{{$photo->path}}">
@endforeach

@endsection
