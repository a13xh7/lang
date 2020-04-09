@extends('main_layout')


@section('content')

    <h1 class="uc">{{__('Settings')}}</h1>

    <form action="{{route('update_settings')}}" method="POST" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="app_lang">{{__('Interface language')}}</label>
            <div class="col-sm-10">
                <select class="form-control" id="app_lang" name="app_lang">

                    @php
                        $engSelected = \App\Config\Config::getAppLangCode() == "en" ? "selected" : "";
                        $ruSelected = \App\Config\Config::getAppLangCode() == "ru" ? "selected" : "";
                    @endphp


                    <option value="en" {{$engSelected}}>English</option>
                    <option value="ru" {{$ruSelected}}>{{__('Russian')}}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_i_learn_id">{{__('Language I learn')}}</label>
            <div class="col-sm-10">
                <select class="selectpicker" name="lang_i_learn_id" id="lang_i_learn_id" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                            @if(\App\Config\Config::getLearnedLanguageId() ==  $lang['id'])
                            selected
                            @endif
                        >
                        </option>

                    @endforeach

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_i_know_id">{{__('Language I know')}}</label>
            <div class="col-sm-10">
                <select class="selectpicker" name="lang_i_know_id" id="lang_i_know_id" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                            @if(\App\Config\Config::getKnowLanguageId() == $lang['id'])
                            selected
                            @endif
                        >
                        </option>

                    @endforeach

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="use_free_translator">{{__('Use free google translate api')}}</label>
            <div class="col-sm-10">
                <select class="form-control" id="use_free_translator" name="use_free_translator">

                    @php
                        $yesSelected = \App\Config\Config::getUseFreeTranslatorSetting() == 1 ? "selected" : "";
                        $noSelected = \App\Config\Config::getUseFreeTranslatorSetting() == 0 ? "selected" : "";
                    @endphp

                    <option value="1" {{$yesSelected}}>{{__('Yes')}}</option>
                    <option value="0" {{$noSelected}}>{{__('No, use official google translate API')}}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="api_key">{{__('Google translate api key')}}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="api_key" name="api_key" placeholder="key" value="{{\App\Config\Config::getApiKey()}}">
            </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius mb-5 uc"><b>{{__('Save')}}</b></button>

    </form>

    <hr>

    <ul>
        <li>{{__('If you are using free google API, google may block your IP because it\'s not actually free and there are limits.')}}</li>
        <li> {{__('To avoid this do not use "Mark all words as" function too often.')}} </li>
        <li> {{__('If translation stopped working you can wait some time for google to unban your IP or switch to official google translate API, set you API key and translate without any limits.')}}</li>
    </ul>

    <ul>
        <li><a href="https://cloud.google.com/translate/pricing">https://cloud.google.com/translate/pricing</a></li>
    </ul>
    <img src="{{asset("img/api.png")}}" alt="">


@endsection

