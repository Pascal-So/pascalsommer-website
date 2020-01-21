@extends('layouts.pascal')

@section('title', 'Upload - Pascal Sommer')

@section('content')

<h1>Photo Upload</h1>

<form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <input role="button" class="pretty-much-hidden" type="file" name="photos[]" id="photos_upload_button" multiple>
    <label class="btn" for="photos_upload_button">Select photos</label><br>

    <p id="files_selected_text">No files selected.</p>

    <br><br>

    <button class="btn">Upload</button>

</form>

<br><br><br><br><br><br>

<script type="text/javascript">
    var input = document.getElementById('photos_upload_button');

    input.addEventListener('change', function(e){
        var text = "No files selected.";

        if(input.files && input.files.length > 1){
            text = input.files.length.toString() + " files selected";
        }else{
            text = input.files[0].name;
        }

        document.getElementById('files_selected_text').innerHTML = text;
    });
</script>

@endsection
