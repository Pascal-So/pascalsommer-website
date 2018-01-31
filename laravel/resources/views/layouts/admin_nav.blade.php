@auth
    <nav class="alignright admin-nav">
        <a class="{{ Route::is('home') ? 'nav-link-active' : '' }}" href="{{ route('home') }}">Home</a>
        <a class="{{ Route::is('uploadForm') ? 'nav-link-active' : '' }}" href="{{ route('uploadForm') }}">Upload</a>
        <a class="{{ Route::is('staging') ? 'nav-link-active' : '' }}" href="{{ route('photos') }}">Staging</a>
        <a class="{{ Route::is('createPost') ? 'nav-link-active' : '' }}" href="{{ route('createPost') }}">New Post</a>
        <a class="{{ Route::is('posts') ? 'nav-link-active' : '' }}" href="{{ route('posts') }}">Posts</a>
        <a class="{{ Route::is('tags') ? 'nav-link-active' : '' }}" href="{{ route('tags') }}">Tags</a>
        <a class="{{ Route::is('comments') ? 'nav-link-active' : '' }}" href="{{ route('comments') }}">Comments</a>
        <span>&nbsp;</span>
        <a href="{{ route('logout') }}">Logout</a>
    </nav>
@endauth