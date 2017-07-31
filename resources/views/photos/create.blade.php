@extends('layouts.app')

@section('title', 'Upload new photos - Pascal Sommer Photography')

@section('content')

	<form method="post" action="{{ action('PhotoController@store') }}" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="form-group">
			<label for="photos">File input</label>
		    <input type="file" id="photos" name="photos[]" multiple>
		    <p class="help-block">You can select multiple files.</p>
		</div>

		<button type="submit" class="btn btn-primary">Upload</button>
	</form>

@endsection