@extends('layouts.pascal')

@section('content')

<h1>
    Photos
</h1>

<a class="toggle {{ $staged_photos ? 'toggle-active' : ''}}" href="{{ route('photos') . '?published-photos=' . $published_photos . '&staged-photos=' . !$staged_photos . '&no-desc=' . $no_desc }}">Include Staged</a>
<br><br>
<a class="toggle {{ $published_photos ? 'toggle-active' : ''}}" href="{{ route('photos') . '?published-photos=' . !$published_photos . '&staged-photos=' . $staged_photos . '&no-desc=' . $no_desc }}">Include Published</a>
<br><br>
<a class="toggle {{ $no_desc ? 'toggle-active' : ''}}" href="{{ route('photos') . '?published-photos=' . $published_photos . '&staged-photos=' . $staged_photos . '&no-desc=' . !$no_desc }}">Missing Description</a>

<br><br>

@if($photos->isEmpty())
    <p>No photos.</p>
@else
    <p>{{ $photos->count() }} photos</p>
@endif

<br>

@foreach($photos as $photo)
    <a href="{{ asset($photo->path) }}" target="blank"><img style="vertical-align: top;" class="photo-small" src="{{ asset($photo->path) }}"></a>
    <div class="admin-index-panel">
        <a class="btn" href="{{ route('editPhoto', compact('photo')) }}">Edit Photo</a>
        <a class="btn" href="{{ route('viewPhoto', compact('photo')) }}">View</a>
        <a data-deletable-photo data-filename="{{ basename($photo->path) }}"
            @if( $photo->isPublic() )
                data-post="{{ str_replace('"', "'", $photo->post->title) }}"
            @endif
            class="btn" href="{{ route('deletePhoto', compact('photo')) }}">Delete</a>
        <br>
        <div style="max-width: 310px;">
            @foreach($photo->tags as $tag)
                <a class="tag" href="{{ route('filtered', ['tags' => $tag->name]) }}">{{ $tag->name }}</a>
            @endforeach
        </div>
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
