<form id="comment-form" class="comment-form" action="{{ route('postComment', compact('photo')) }}" method="post">
    {{ csrf_field() }}

    @include('layouts.errors')

    <br><br>

    <input type="text" placeholder="Name" id="name" name="name" maxlength="255" style="margin-bottom: 5px" required value="{{ old('name') }}">
    <br>

    <textarea name="comment" id="comment" placeholder="Comment" maxlength="5000" required rows="4">{{ old('comment') }}</textarea>

    <br><br>
    <button class="btn">Post Comment</button>

</form>