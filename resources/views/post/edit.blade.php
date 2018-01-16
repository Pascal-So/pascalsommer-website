@extends('layouts.pascal')

@section('content')

<h1>Post</h1>

<form method="POST" action="{{ route('storePost') }}">
    {{ csrf_field() }}

    <label for="title">Title </label>
    <input id="title" type="text" name="title" value="{{ old("title") }}">
    <br><br>
    <label for="date">Date </label>
    <input type="text" name="date" placeholder="YYYY-MM-DD" value="{{ old("date", date('Y-m-d')) }}">

    <br><br>

    @include('layouts.errors')

    <br><br>

    <button class="btn">Save</button>
</form>

<br><br><br>

@endsection
