@extends('main_layout')


@section('content')

    <h1 class="uc">Upload dictionary</h1>

    <p>Allowed file format - <b>json</b></p>

    <p>Allowed format: <code>[ {"word1":"translation"} , {"word2":"translation"} ]</code></p>

    <p> By default word status is new(0) so words from dictionary will appears in your words only after you translate them first time.</p>

    <p><b>P.S.</b> You also can upload explanatory dictionary. Just translate text to the same language (english -> english).</p>

    <hr>

    <form action="{{route('words_upload')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="words_lang_id">Words language</label>
            <div class="col-sm-10">
                <select class="selectpicker" name="words_lang_id" id="words_lang_id" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>">
                        </option>

                    @endforeach

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="translation_lang_id">Translation language</label>
            <div class="col-sm-10">

                <select class="selectpicker" name="translation_lang_id" id="translation_lang_id" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>">
                        </option>

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

        <button type="submit" class="btn w-100 btn-primary noradius"><b>UPLOAD</b></button>

    </form>



@endsection

