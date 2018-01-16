@extends('layouts.pascal')

@section('content')

<h1>Photos</h1>

@foreach($photos as $photo)
    <img style="vertical-align: top;" class="photo-small" src="{{ asset($photo->path) }}">
    <div style="display: inline-block; vertical-align: top; margin-left: 15px; text-align: left">
        <a class="btn" href="{{ route('editPhoto', compact('photo')) }}">Edit Photo</a>
        <a class="btn" href="{{ route('viewPhoto', compact('photo')) }}">View Photo</a>
        <br>
        <p>
            @if($photo->isPublic())
                in "{{ $photo->post->title }}"
            @else
                Staged
            @endif
        </p>
        <p style="width: 300px">{!! $photo->descriptionHTML() !!}</p>
    </div>
    <br><br>
@endforeach

@endsection
