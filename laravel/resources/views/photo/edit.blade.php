@extends('layouts.pascal')

@section('title', 'Edit Photo ' . $photo->id . ' - Pascal Sommer')

@section('content')

<h1>Edit Photo</h1>

<h2>
    @if( $photo->isPublic() )
        (live in "{{ $photo->post->title }}")
    @endif
</h2>
<a class="btn" href="{{ $photo->url() }}">View Photo</a>
<br>
<br>
<br>
<div class="flex-row flex-center" id="photo">
    @if($photo->prevPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a id="link-left" href="{{ route('editPhoto', ['photo' => $photo->prevPhoto()]) }}#photo"><img class="arrow-icon" src="{{ asset('img/icons/larrow.svg') }}"></a>
    @endif
    <img src="{{ asset($photo->path) }}" class="photo" id="photo">
    @if($photo->nextPhoto() == null)
        <div class="arrow-icon-placeholder"></div>
    @else
        <a id="link-right" href="{{ route('editPhoto', ['photo' => $photo->nextPhoto()]) }}#photo"><img class="arrow-icon" src="{{ asset('img/icons/rarrow.svg') }}"></a>
    @endif
</div>

<br><br>

<div id="tags" class="flex-row flex-center flex-wrap photo" style="margin: auto;">
@foreach($tags as $tag)
    @if($photo->tags->contains($tag))
        <a class="tag tag-active" href="{{ route('removeTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    @else
        <a class="tag" href="{{ route('addTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    @endif
@endforeach
</div>

<br><br>

<form method="POST" action="{{ route('updatePhoto', compact('photo')) }}">
    {{ csrf_field() }}

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="5" cols="55">{{ $photo->description}}</textarea>

    <br><br>

    <button class="btn">Save Description</button>

</form>

@endsection
