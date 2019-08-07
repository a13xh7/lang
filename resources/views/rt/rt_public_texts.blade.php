@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1 class="uc">{{__('Public texts')}}</h1>

        <div class="q_lang_filter">

            <label for="lang_from">{{__('I know')}}</label>
            <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                            @if($textsTranslateToLangId == $lang['id'])
                            selected
                            @endif
                    >
                    </option>

                @endforeach

            </select>

            <br><br>
            <label for="lang_to">{{__('I want to learn')}}</label>

                <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                                @if($textsLangId == $lang['id'])
                                selected
                                @endif
                        >
                        </option>

                    @endforeach

                </select>

            <button type="submit" class="btn w-100 btn-primary noradius" style="margin: 15px 0;" id="pt_filter"><b>{{__('FILTER')}}</b></button>

        </div>

    @foreach($texts as $text)


        <div class="row text_item border-bottom text_item_wrapper">

            <div class="col">
                <span class="text_title">
               <span class="h4" href="">{{$text->title}}</span> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

                <div>
                    {{__('Text language')}}: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['title']}})</i>
                    <span class="q_lang_arrow">⟶</span>
                    {{__('Translate to')}}: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->translate_to_lang_id)['title']}})</i>
                </div>

                <div class="text_stats">
                    {{__('Symbols')}}: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                    {{__('Words')}}: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                    {{__('Unique words')}}: <span class="badge badge-dark">{{ $text->unique_words}}</span>
                    <br>
                    {{--{{__('Known words')}}: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>--}}
                    {{--{{__('Unknown Words')}}: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>--}}
                </div>

            </div>

            <div class="col-auto">

                <div style="vertical-align: middle">
                    <i class="icofont-users-alt-3" style="font-size: 30px; vertical-align: middle" ></i>
                    <b>{{__('Users')}}:</b> <span class="badge badge-secondary">{{ count($text->users) }}</span>
                </div>

                <div>
                    <i class="icofont-question-square" style="font-size: 25px; vertical-align: middle" ></i>
                    <b>{{__('Questions')}}:</b> <span class="badge badge-secondary">{{ \App\Models\QA\Question::where('text_id', $text->id)->count() }}</span>
                </div>

                <div class="text_controls" align="right">

                    @if($text->users()->where('user_id', auth()->user()->id)->first() == null)
                        <a class="btn btn-primary text-light noradius w-100" href="{{ route('rt_get_public_text', $text->id) }}" >
                            <i class="icofont-read-book"></i> {{__('Read')}}
                        </a>
                    @endif

                </div>

            </div>





        </div>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection
