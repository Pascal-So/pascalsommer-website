@extends('layouts.base')

@section('content-base')

<div class="fullpage">
    <div class="centered">
        <h2>404</h2>

        <p>There is nothing here.</p>

        <a href="{{ route('home') }}">Home</a>
    </div>
</div>


<style type="text/css">
.centered{
    margin: auto;
}

.fullpage{
    position: absolute;
    z-index: 0;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;

    display: grid;
}
</style>

@endsection
