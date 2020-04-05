@extends('main_layout')


@section('content')

    <h1 class="uc">Upload dictionary</h1>

    <p>Allowed file format - <b>json</b></p>

    <p>Allowed format: <code>[ {"word1":"translation"} , {"word2":"translation"} ]</code></p>

    <p><b>P.S.</b> You may upload explanatory dictionary.</p>

    <hr>

    <form action="{{route('words_upload')}}" method="POST" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">File</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <label class="custom-file-label" for="text_file">Choose file</label>
                    <input type="file" class="custom-file-input" name="text_file" id="text_file" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius"><b>UPLOAD</b></button>

    </form>



@endsection

