@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1>Public texts</h1>

    @foreach($texts as $text)


        <div class="row text_item border-bottom text_item_wrapper">

            <div class="col">
                <span class="text_title">
               <a class="h4" href="">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

                <div>
                    Text language: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['title']}})</i>
                    <span class="q_lang_arrow">⟶</span>
                    Translate to: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->translate_to_lang_id)['title']}})</i>
                </div>

                <div class="text_stats">
                    Symbols: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                    Words: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                    Unique words: <span class="badge badge-dark">{{ $text->unique_words}}</span>
                    <br>
                    Known words: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>
                    Unknown Words: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>
                </div>

            </div>

            <div class="col-auto">

                <div style="vertical-align: middle">
                    <i class="icofont-users-alt-3" style="font-size: 30px; vertical-align: middle" ></i>
                    <b>Users:</b> <span class="badge badge-secondary">{{ count($text->users) }}</span>
                </div>

                <div>
                    <i class="icofont-question-square" style="font-size: 25px; vertical-align: middle" ></i>
                    <b>Questions:</b> <span class="badge badge-secondary">{{ \App\Models\QA\Question::where('text_id', $text->id)->count() }}</span>
                </div>

                <div class="text_controls" align="right">

                    @if($text->users()->where('user_id', auth()->user()->id)->first() == null)
                        <a class="btn btn-primary text-light noradius w-100" href="{{ route('rt_get_public_text', $text->id) }}" >
                            <i class="icofont-read-book"></i> READ
                        </a>
                    @endif

                </div>

            </div>





        </div>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection