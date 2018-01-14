@extends('layouts.pascal')

@section('content')

<h1>Tags</h1>

@if($tags->count())
    <form method="POST" action="{{ route('updateAllTags') }}">
        {{ csrf_field() }}

        <ul>
            @foreach($tags as $tag)
                <li>
                    <input style="vertical-align: baseline" type="text" name="tags[{{$tag->id}}][name]" value="{{ $tag->name }}">
                    <span>&nbsp;</span>
                    <a style="vertical-align: baseline" class="btn" href="{{ route('deleteTag', compact('tag')) }}">Delete</a>
                    <span>&nbsp;</span>
                    <a href="{{ route('filtered', ['tags' => $tag->name]) }}">{{ $tag->photos_count }} photos</a>
                </li>
            @endforeach
        </ul>

        <button class="btn">Save Changes</button>
    </form>
@else
    <p>No tags</p>
@endif

<br><br>

<h2>New Tag</h2>
<form method="POST" action="{{ route('storeTag') }}">
    {{ csrf_field() }}
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <br><br>
    <button class="btn">Save</button>
</form>

@endsection
