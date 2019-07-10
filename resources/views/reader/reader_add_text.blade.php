@extends('layouts.reader.reader_layout')

@section('reader_content')

    <h1>Upload text file</h1>

    <p><b>Allowed file types:</b> <span class="badge badge-info">.txt</span></p>

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
                    <option value="{{$lang->id}}" data-thumbnail="{{asset('img/flags/en.svg')}}">ZZZZZZZ</option>
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
                    <input type="file" class="custom-file-input" name="text_file" id="text_file" required accept=".txt">
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius"><b>UPLOAD</b></button>

    </form>

    {{--<h1>Or open url</h1>--}}

    {{--<br><br>--}}


@endsection

