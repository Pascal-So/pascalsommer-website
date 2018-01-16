@extends('layouts.pascal')

@section('content')

<h1>Post</h1>

<form method="POST" action="{{ route('storePost') }}">
    {{ csrf_field() }}

    <label for="name">Name </label>
    <input id="name" type="text" name="name">
    <br><br>
    <label for="date">Date </label>
    <input type="text" name="date" placeholder="YYYY-MM-DD">

    <br><br><br>

    <button class="btn">Save</button>
</form>

@endsection
