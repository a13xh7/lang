@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1>My texts</h1>


    @foreach($texts as $text)


        <div class="row text_item border-bottom text_item_wrapper">

            <div class="col">
                <span class="text_title">
               <a class="h4" href="{{route('reader_read_text_page', $text->id)}}?page=@if($text->pivot->current_page <= 0){{$text->pivot->current_page + 1}}@else{{$text->pivot->current_page}}@endif">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
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

                <div class="text_pages_info">
                    Pages: <span class="badge badge-dark">{{ $text->total_pages}}</span> <b>/</b>
                    Current page: <span class="badge badge-dark">{{ $text->pivot->current_page}}</span>
                </div>

                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                         style="width: @php
                             try {
                                 echo $text->pivot->current_page / $text->total_pages  * 100 . "%";
                             } catch (\Exception $e) {
                                 echo "0%";
                             }
                         @endphp
                                 " aria-valuenow="2" aria-valuemin="0" aria-valuemax="100">
                    </div>
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

                    <?php

                    if( $text->pivot->current_page <= 0 ) {
                        $urlGetParam = "?page=1";
                    } else {
                        $urlGetParam = "?page=". $text->pivot->current_page;
                    }

                    $urlGetParam.="&public=1";

                    ?>

                    <a class="btn btn-primary text-light noradius w-100 mb-1" href="{{route('reader_read_text_page', $text->id)}}{{$urlGetParam}}">
                        <i class="icofont-read-book"></i> Read
                    </a> <br>

                    <a class="btn btn-primary text-light noradius w-100 mb-1" href="{{ route('reader_text_stats', $text->id) }}?public=1">
                        <i class="icofont-info-square"></i> Full Info
                    </a> <br>

                    <a class="btn btn-primary text-light noradius w-100" href="{{route('rt_delete_my_text', $text->id)}}">
                        <i class="icofont-ui-delete"></i> Delete
                    </a>
                </div>
            </div>



        </div>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection
