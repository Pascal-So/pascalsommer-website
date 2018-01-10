<ul>
	@foreach($comments as $comment)

		<li class="comment" id="comment_{{ $comment->id }}">
			<h2><a href="">{{ $comment->name }}</a></h2>
			<p>{{ $comment->created_at->format('Y-m-d') }}</p>
			<p>{{ $comment->comment }}</p>

			@auth
				<a href="{{ route('deleteComment', compact('comment')) }}"><button>delete</button></a>
			@endauth
		</li>
		<br>

	@endforeach
</ul>
