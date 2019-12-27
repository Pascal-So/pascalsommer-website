<form id="comment-form" class="comment-form" action="{{ route('postComment', compact('photo')) }}" method="post">
    {{ csrf_field() }}

    @if ($errors->any())
        @include('layouts.errors')
        <br>
    @endif

    <input
        type="text"
        placeholder="Name"
        id="name-field"
        class="fill-parent"
        name="name"
        maxlength="255"
        style="margin: 5px 0"
        required
        value="{{ old('name') }}"
    >

    <br>

    <textarea
        name="comment"
        id="comment-field"
        class="fill-parent"
        placeholder="Comment"
        maxlength="5000"
        required
        rows="4"
    >{{ old('comment') }}</textarea>

    <br>

    <button
        style="margin: 5px 0"
        class="btn fill-parent"
    >Post Comment</button>

</form>