@extends("layouts.app")

@section("content")

<div class="container">

		<h1>Staged Photos</h1>

		<ul class="list-group">
			@foreach($photos as $photo)

				<li class="list-group-item row">
					<div class="col-sm-4 form-group">
						<a href="{{ asset($photo->path) }}"><img src="{{ asset($photo->path ) }}" alt="{{ $photo->description }} - Photo by Pascal Sommer" class="img-responsive img-rounded"></a>
					</div>

					<div class="col-sm-8">
						<div class="card-block">

							<form action="{{ action('PhotoController@update', $photo) }}" method='post'>
								{{ csrf_field() }}

								<div class="form-group">
									<textarea class="form-control" rows="4">{{ $photo->description }}</textarea>
								</div>

								<div class="form-group btn-toolbar">
									<div class="btn-group">
										<button type="submit" class="btn btn-primary">Save</button>
									</div>
									<div class="btn-group">
										<a href="{{ action('PhotoController@destroy', $photo) }}" class="btn btn-danger">Delete</a>
									</div>
									<div class="btn-group">
										<a href="#" class="btn btn-default" @if($loop->first) disabled="disabled" @endif >Up</a>
										<a href="#" class="btn btn-default" @if($loop->last) disabled="disabled" @endif >Down</a>
									</div>
								</div>
							</form>
							
						</div>
					</div>
				</li>

			@endforeach
		</ul>

	</div>

@endsection