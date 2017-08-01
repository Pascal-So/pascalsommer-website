<ul class="list-group">
	@foreach($comments as $comment)
		<li class="list-group-item">
			<p><strong>{{ $comment->name }}</strong></p>
			<p>{{ $comment->content }}</p>
		</li>
	@endforeach
</ul>