@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1>Public texts</h1>

    @foreach($texts as $text)


        <div class="text_item border-bottom text_item_wrapper">

            <span class="text_title">
               <a class="h4" href="">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

            <div>
                Text language: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['title']}})</i>
                <span class="q_lang_arrow">⟶</span>
                {{--Translate to: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->pivot->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->pivot->translate_to_lang_id)['title']}})</i>--}}
            </div>

            <div class="text_stats">
                Symbols: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                Words: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                Unique words: <span class="badge badge-dark">{{ $text->unique_words}}</span> <b>|</b>
                Known words: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>
                Unknown Words: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>
            </div>


            <div class="text_controls">

                <a class="btn btn-primary text-light noradius" href="#">
                    <i class="icofont-read-book"></i> READ
                </a>



                {{--<a class="btn btn-primary text-light noradius text_edit_btn" data-toggle="modal" data-target="#text_edit_modal"--}}
                   {{--data-text_id="{{$text->id}}"--}}
                   {{--data-text_title="{{$text->title}}"--}}
                   {{--data-text_lang="{{$text->lang_id}}">--}}

                    {{--<i class="icofont-ui-edit"></i> Edit--}}
                {{--</a>--}}


            </div>

        </div>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection