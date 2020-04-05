@extends('main_layout')


@section('content')

    <h1 class="uc">Settings</h1>

    <form action="{{route('update_settings')}}" method="POST" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="lang_i_learn_id">Language I learn</label>
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
            <label class="col-sm-2 col-form-label" for="lang_i_know_id">Language I know</label>
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

        <button type="submit" class="btn w-100 btn-primary noradius mb-5"><b>SAVE</b></button>

    </form>




@endsection

