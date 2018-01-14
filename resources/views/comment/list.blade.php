<ul>
    @foreach($comments as $comment)

        <li class="comment" id="comment_{{ $comment->id }}">
            <h2>
                <a href="{{ route('viewPhoto', ['photo' => $comment->photo]) }}#comment_{{ $comment->id }}">
                    {{ $comment->name }}
                </a>
            </h2>
            @auth
                @if(isset($admin_overview) && $admin_overview)
                    <p>On a photo in <a href="{{ route('viewPhoto', ['photo' => $comment->photo]) }}">{{ $comment->photo->post->title }}</a></p>
                @endif
            @endauth
            <p>{{ $comment->created_at->format('Y-m-d') }}</p>
            <p>{{ $comment->comment }}</p>

            @auth
                <a href="{{ route('deleteComment', compact('comment')) }}"><button class="btn">Delete</button></a>
            @endauth
        </li>
        <br>

    @endforeach
</ul>
