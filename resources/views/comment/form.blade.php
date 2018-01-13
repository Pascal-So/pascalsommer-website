<form class="comment-form" action="{{ route('postComment', compact('photo')) }}" method="post">
    {{ csrf_field() }}


    <label for="name">Name</label>
    <input type="text" name="name" maxlength="255" required value="{{ old('name') }}">
    <br><br>

    <label for="comment">Comment</label>
    <textarea name="comment" maxlength="5000" required rows="4" cols="25">{{ old('name') }}</textarea>

    <br><br>
    <button>Post Comment</button>

</form>