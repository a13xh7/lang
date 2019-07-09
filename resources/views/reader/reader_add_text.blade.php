@extends('layouts.reader.reader_layout')

@section('reader_content')

    <h1>Upload text file</h1>
    <hr>

    <form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="text_title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="text_title" id="text_title" placeholder="Text title" required>
            </div>
        </div>

        {{--<div class="form-group row">--}}
            {{--<label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Short about</label>--}}
            {{--<div class="col-sm-10">--}}
                {{--<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>--}}
            {{--</div>--}}
        {{--</div>--}}


        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Translate from</label>
            <div class="col-sm-10">
                <select class="form-control" name="lang_from">
                    @foreach($languages as $lang)
                        <option value="{{$lang->id}}">{{$lang->eng_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Translate to</label>
            <div class="col-sm-10">
                <select class="form-control" name="lang_to">
                    @foreach($languages as $lang)
                        <option value="{{$lang->id}}">{{$lang->eng_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">File</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <label class="custom-file-label" for="text_file">Choose file</label>
                    <input type="file" class="custom-file-input" name="text_file" id="text_file" required>
                </div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <div class="col">
                <button type="submit" class="btn btn-primary noradius">UPLOAD TEXT</button>
            </div>
        </div>
    </form>

    <h1>Or open url</h1>

    <br><br>

    {{--<form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">--}}

        {{--@csrf--}}
        {{--<input type="text" name="text_title" value="tetx title"><br>--}}
        {{--<input type="file" name="textFile" id="text_file"><br>--}}

        {{--Lang from <select name="lang_from">--}}
            {{----}}
            {{--@foreach($languages as $lang)--}}

                {{--<option value="{{$lang->id}}">{{$lang->eng_title}}</option>--}}
                {{----}}
            {{--@endforeach--}}
           {{----}}
        {{--</select><br>--}}

        {{--Lang to <select name="lang_to">--}}
            {{--@foreach($languages as $lang)--}}

                {{--<option value="{{$lang->id}}">{{$lang->eng_title}}</option>--}}

            {{--@endforeach--}}
        {{--</select><br>--}}
        {{----}}
        {{--<button type="submit" name="submit">Upload</button>--}}

    {{--</form>--}}

@endsection

