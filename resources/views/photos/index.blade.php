@extends("layouts.app")

@section("content")




	<ul class="list-group">
		@foreach($photos as $photo)

			<li class="list-group-item row">
				<div class="col-md-4">
					<a href="{{ asset($photo->path) }}"><img src="{{ asset($photo->path ) }}" alt="{{ $photo->description }} - Photo by Pascal Sommer" class="img-responsive img-rounded"></a>
				</div>

				<div class="col-md-8 px-3">
					<div class="card-block px-3">
						<h4 class="card-title"><a href="{{ asset($photo->path) }}">{{ $photo->path }}</a></h4>

						<p class="card-text">
							@if($photo->description == "")
								<em>No description given</em>
							@else
								{{ $photo->description }}
							@endif

						</p>

						
						<div class="btn-group">
							<a href="#" class="btn btn-default">Move Up</a>
							<a href="#" class="btn btn-default">Move Down</a>
							<a href="{{ url('/photos/' . $photo->id . '/edit') }}" class="btn btn-primary">Edit</a>
						</div>
					</div>
	          </div>
				{{-- <p class="text-right col-md-4">Some text here.. {{ $photo->description }}</p> --}}

			</ul>

		@endforeach
	</ul>

@endsection