@extends('layouts.pascal')

@section('content')

<h1>Tags</h1>

@if($tags->count())
    <form method="POST" action="{{ route('updateAllTags') }}">
        <ul>
            @foreach($tags as $tag)
                <li>
                    <label for="tags[{{$tag->id}}][name]"></label>
                    <input type="text" name="tags[{{$tag->id}}][name]">{{ $tag->name }}
                    <button class="btn"><a href="{{ route('deleteTag', compact('tag')) }}">Delete</a></button>
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
