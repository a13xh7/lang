@extends('layouts.reader.reader_layout')

@section('reader_sidebar')

    @if(app('request')->get('public') == 1)
        @include('layouts.rt.rt_left_sidebar')
    @else
        @include('layouts.reader.reader_left_sidebar')
    @endif


@endsection


@section('reader_content')

    <h1 class="гс">{{__('Upload text file')}}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>
        <b>{{__('Allowed file types')}}:</b>
        <span class="badge badge-info">.txt</span>
        <span class="badge badge-info">.fb2</span>
        <span class="badge badge-info">.pdf</span>
    </p>

    <form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="text_title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="text_title" id="text_title" placeholder="Text title" required>
            </div>
        </div>

        <input type="hidden" id="text_pubic" name="text_pubic" value="@if(app('request')->get('public') == 1) 1 @else 0 @endif">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_from">{{__('Text language')}}</label>
            <div class="col-sm-10">
                <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                        >
                        </option>

                    @endforeach

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_to">{{__('Translate to')}}</label>
            <div class="col-sm-10">

                <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                        >
                        </option>

                    @endforeach

                </select>

            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">{{__('File')}}</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <label class="custom-file-label" for="text_file">{{__('Choose file')}}</label>
                    <input type="file" class="custom-file-input" name="text_file" id="text_file" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius"><b>{{__('UPLOAD')}}</b></button>

    </form>

    <hr>

    <h1>{{__('Or add plain text')}}</h1>

    <form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="text_title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="text_title" id="text_title" placeholder="Text title" required>
            </div>
        </div>

        <input type="hidden" id="text_pubic" name="text_pubic" value="@if(app('request')->get('public') == 1) 1 @else 0 @endif">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_from">{{__('Text language')}}</label>
            <div class="col-sm-10">
                <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"
                        >
                        </option>

                    @endforeach

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_to">{{__('Translate to')}}</label>
            <div class="col-sm-10">

                <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"
                        >
                        </option>

                    @endforeach

                </select>

            </div>
        </div>

        <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label">{{__('Text')}}</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="text" name="text" rows="5" required></textarea>
                </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius mb-5"><b>{{__('UPLOAD')}}</b></button>

    </form>


@endsection

