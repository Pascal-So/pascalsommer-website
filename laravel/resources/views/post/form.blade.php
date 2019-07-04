@php

    $post->title = old("title", $post->title);
    $post->date = old("date", $post->date ?: date('Y-m-d'));

    //$photos_in_post_ids = json_encode($post->photos->pluck('id'));
    //$actual_ids_array = json_decode(old("photos", $photos_in_post_ids));

    $ids_array = old("photos", $post->photos->pluck('id'));

    $post_photos = App\Photo::whereIn('photos.id', $ids_array)->blogOrdered()->get()->toArray();

@endphp

<div id="post-photos" class="hidden">{{ json_encode($post_photos) }}</div>
<div id="staged-photos" class="hidden">{{ json_encode($staged) }}</div>
<div id="asset-path" class="hidden">{{ asset('') }}</div>
<div id="view-path" class="hidden">{{ route('viewPhoto', ['photo' => '']) . '/' }}</div>

<form method="POST" action="{{ $action }}">
    {{ csrf_field() }}

    @include('layouts.errors')

    <br><br>

    <label for="title">Title </label>
    <input id="title" type="text" name="title" value="{{ $post->title }}" required>
    <br><br>
    <label for="date">Date </label>
    <input id="date" type="text" name="date" placeholder="YYYY-MM-DD" value="{{ $post->date }}" required>

    <br><br>

    <button class="btn">Save Post</button>

    <br><br><br>

    <div id="photo-selector"></div>
</form>