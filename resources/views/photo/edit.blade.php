@extends('layouts.pascal')

@section('content')

<h1>Edit Photo</h1>

<h2>
    @if( $photo->isPublic() )
        (live in "{{ $photo->post->title }}")
    @endif
</h2>
<a class="btn" href="{{ route('viewPhoto', compact('photo')) }}">View Photo</a>
<br>
<br>
<br>
<img src="{{ asset($photo->path) }}" class="photo">

<br><br>

<div id="tags">
@foreach($tags as $tag)
    @if($photo->tags->contains($tag))
        <a class="tag-active" href="{{ route('removeTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    @else
        <a class="tag" href="{{ route('addTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    @endif
@endforeach
</div>
{{-- 
<label id="tags">Remove Tags </label>

@foreach($photo->tags as $tag)
    <span class="tag-active">
        -&nbsp;<a href="{{ route('removeTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    </span>
@endforeach

<br>

<label>Add Tags </label>

@foreach($other_tags as $tag)
    <span class="tag">
        +&nbsp;<a href="{{ route('addTag', compact('photo', 'tag')) }}">{{ $tag->name }}</a>
    </span>
@endforeach
 --}}
<br><br>

<form method="POST" action="{{ route('updatePhoto', compact('photo')) }}">
    {{ csrf_field() }}

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="5" cols="55">{{ $photo->description}}</textarea>

    <br><br>

    <button class="btn">Save Description</button>

</form>


@endsection
