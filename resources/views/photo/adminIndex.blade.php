@extends('layouts.pascal')

@section('content')

<h1>
    @if($only_staging)
        Staged 
    @endif
    Photos
</h1>

@if($only_staging)
    <a class="btn" href="{{ route('photos') }}">View all Photos</a>
@else
    <a class="btn" href="{{ route('staging') }}">View only staged Photos</a>
@endif

<br><br><br>

@foreach($photos as $photo)
    <a href="{{ asset($photo->path) }}" target="blank"><img style="vertical-align: top;" class="photo-small" src="{{ asset($photo->path) }}"></a>
    <div style="display: inline-block; vertical-align: top; margin-left: 15px; text-align: left">
        <a class="btn" href="{{ route('editPhoto', compact('photo')) }}">Edit Photo</a>
        <a class="btn" href="{{ route('viewPhoto', compact('photo')) }}">View Photo</a>
        <a data-deletable-photo data-filename="{{ basename($photo->path) }}"
            @if( $photo->isPublic() )
                data-post="{{ str_replace('"', "'", $photo->post->title) }}"
            @endif
            class="btn" href="{{ route('deletePhoto', compact('photo')) }}">Delete Photo</a>
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
