@extends('main_layout')


@section('content')

    <h1 class="uc">{{__('My words')}}</h1>


    <div class="form-group row">
        <label class="col-md-auto col-form-label" for="w_lang"><b>{{__('Words language')}}</b></label>
        <div class="col">
            <select class="selectpicker" name="w_lang" id="w_lang" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                            @if($wordsLangId == $lang['id'])

                                selected

                            @endif
                    >

                    </option>

                @endforeach

            </select>
        </div>
    </div>


    <div class="form-group row">
        <label class="col-md-auto col-form-label" for="wt_lang"><b>{{__('Translation language')}}</b></label>
        <div class="col">
            <select class="selectpicker" name="wt_lang" id="wt_lang" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                            @if($wordsTranslationLangId == $lang['id'])

                            selected

                            @endif
                    >

                    </option>

                @endforeach

            </select>
        </div>
    </div>

    <hr>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="show_all_words">
                <span class="h2">{{__('ALL')}}: <span class="badge badge-light">{{ $totalWords }}</span> </span>
            </button>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius" id="show_unknown_words">
                <span class="h2">{{__('TO STUDY')}}: <span class="badge badge-warning">{{ $totalNewWords }} </span> </span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary noradius" id="show_known_words">
                <span class="h2">{{__('KNOWN')}}: <span class="badge badge-success">{{ $totalKnownWords }}</span> </span>
            </button>
        </li>

    </ul>



    <table class="table" id="all_text_words">
        <thead class="thead-light">
        <tr>
            <th>{{__('State')}}</th>
            <th scope="col">{{__('Word')}}</th>
            <th scope="col">{{__('Translation')}}</th>
        </tr>
        </thead>
        <tbody>


    @foreach($words as $word)

        <tr>
            <td>

                {{--
                    для всех слов - нужно показывать две кнопки. знакомое или к изучению
                    для незнакомых слов - показывать кнопку - "сделать слово знакомым"
                    для знакомых слов - только badge
                --}}



                {{--All words tab - allow user to set any state wor a word--}}
                @if(\Illuminate\Support\Facades\Cookie::get('show_words') == 0)

                    @if($word->pivot->state == \App\Config\WordConfig::TO_STUDY )
                        <span class="badge badge-warning h4">To study</span>
                        <button type="button" class="btn btn-success btn-sm words_btn"
                                data-word_id="{{$word->id}}"
                                data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                    @endif

                    @if($word->pivot->state == \App\Config\WordConfig::KNOWN )
                        <button type="button" class="btn btn-warning btn-sm words_btn"
                                data-word_id="{{$word->id}}"
                                data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                        <span class="badge badge-success h4">Known</span>
                    @endif


                 {{--To study tab - --}}
                @elseif(\Illuminate\Support\Facades\Cookie::get('show_words') == \App\Config\WordConfig::TO_STUDY)

                    <button type="button" class="btn btn-success btn-sm words_btn"
                            data-word_id="{{$word->id}}"
                            data-state="{{\App\Config\WordConfig::KNOWN}}">Mark as known</button>

                {{-- Know words tab - --}}
                @elseif(\Illuminate\Support\Facades\Cookie::get('show_words') == \App\Config\WordConfig::KNOWN)

                    <span class="badge badge-success h4">Known</span>

                @endif


            </td>
            <td>{{$word->word}}</td>
            <td> {{$word->googleTranslation->translation}} </td>
        </tr>



    @endforeach

        </tbody>
    </table>

    {{$words->links()}}


@endsection

