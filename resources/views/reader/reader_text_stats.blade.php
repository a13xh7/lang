@extends('layouts.reader.reader_layout')

@section('reader_sidebar')

    @if(app('request')->get('public') == 1)
        @include('layouts.rt.rt_left_sidebar')
    @else
        @include('layouts.reader.reader_left_sidebar')
    @endif

@endsection

@section('reader_content')


    <h1>{{__('Stats')}}</h1>
    <div class="w3-border-bottom">
        <ul>

            <li>
                {{__('Text language')}}:  <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt="">{{\App\Config\Lang::get($text->lang_id)['title']}}
                <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['eng_title']}})</i>
            </li>
            <li>
                {{__('Translate to')}}:  <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->translate_to_lang_id)['code'] .'.svg')}}" class="text_flag" alt="">{{\App\Config\Lang::get($text->translate_to_lang_id)['title']}}
                <i class="text-muted">({{\App\Config\Lang::get($text->translate_to_lang_id)['eng_title']}})</i>
            </li>
            <li>{{__('Pages')}}: <b>{{$text->total_pages}}</b></li>
            <li>{{__('Symbols')}}: <b>{{ $text->total_symbols}}</b></li>
            <li>{{__('Total words')}}: <b>{{ $text->total_words}}</b></li>
            <li>{{__('Unique words')}}: <b>{{ $text->unique_words}}</b></li>
        </ul>

        <p> </p>



    </div>

    <h1>{{__('Words')}} <span class="h6 text-muted">{{__('Click on buttons to filter words')}}</span></h1>

    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="show_all_words">
                <span class="h3">{{__('ALL')}}: <span class="badge badge-dark"> {{ $text->unique_words}}</span> </span>
            </button>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="show_unknown_words">
                <span class="h3">{{__('UNKNOWN')}}: <span class="badge badge-warning"> {{ count($text->getUnknownWords()) }}</span> </span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary noradius" id="show_known_words">
                <span class="h3">{{__('KNOWN')}}: <span class="badge badge-success">{{ count($knownWords) }}</span> </span>
            </button>
        </li>

    </ul>

    {{--<form action="{{route('reader_add_new_word')}}" method="POST">--}}
{{--@csrf--}}
        {{--word <input type="text" name="word">--}}
        {{--lang id <input type="text" name="lang_id" value="1">--}}
        {{--state <input type="text" name="state" value="1">--}}
        {{--<button type="submit">Send</button>--}}

    {{--</form>--}}


    <div class="row">

        <table class="table" id="all_text_words">
            <thead class="thead-light">
            <tr>
                <th>{{__('State')}}</th>
                <th scope="col">{{__('Word')}}</th>
                <th scope="col">{{__('Usage frequency')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($words as $word)

                <tr>
                    <td>

                        @if(!in_array($word[0], $knownWords))
                            <button type="button" class="btn btn-warning btn-sm word_btn"
                                    data-word="{{$word[0]}}"
                                    data-lang_id="{{$text->lang_id}}"
                                    data-translate_to_lang_id="{{$text->translate_to_lang_id}}"
                                    data-state="{{\App\Config\WordConfig::TO_STUDY}}">{{__('To study')}}</button>

                            <button type="button" class="btn btn-success btn-sm word_btn"
                                    data-word="{{$word[0]}}"
                                    data-lang_id="{{$text->lang_id}}"
                                    data-translate_to_lang_id="{{$text->translate_to_lang_id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">{{__('Known')}}</button>

                        @else


                            @if($myWords->where('word', $word[0])->first()->pivot->state == \App\Config\WordConfig::TO_STUDY)
                                <span class="badge badge-warning h4">{{__('To study')}}</span>
                            @else
                                <span class="badge badge-success h4">{{__('Known')}}</span>
                            @endif

                        @endif


                    </td>
                    <td>{{$word[0]}}</td>
                    <td>{{$word[1]}} <span class="small text-muted">{{$word[2]}}%</span> </td>
                </tr>

            @endforeach



            </tbody>
        </table>

</div>

    {{$paginator->links()}}




@endsection
