@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1>My texts</h1>

    @foreach($texts as $text)


        <div class="text_item border-bottom text_item_wrapper">

            <span class="text_title">
               <a class="h4" href="{{route('reader_read_text_page', $text->id)}}?page=@if($text->pivot->current_page <= 0){{$text->pivot->current_page + 1}}@else{{$text->pivot->current_page}}@endif">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

            <div>
                Text language: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['eng_title']}})</i> <b>|</b>
                Translate to: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->pivot->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->pivot->translate_to_lang_id)['eng_title']}})</i>
            </div>

            <div class="text_stats">
                Symbols: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                Words: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                Unique words: <span class="badge badge-dark">{{ $text->unique_words}}</span> <b>|</b>
                Known words: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>
                Unknown Words: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>
            </div>


            <div class="text_controls">

                <a class="btn btn-primary text-light noradius" href="{{route('reader_read_text_page', $text->id)}}?page=@if($text->pivot->current_page <= 0){{$text->pivot->current_page + 1}}@else{{$text->pivot->current_page}}@endif">
                    <i class="icofont-read-book"></i> Read
                </a>

                <a class="btn btn-primary text-light noradius" href="{{ route('reader_text_stats', $text->id) }}">
                    <i class="icofont-info-square"></i> Full Info
                </a>

                <a class="btn btn-primary text-light noradius text_edit_btn" data-toggle="modal" data-target="#text_edit_modal"
                   data-text_id="{{$text->id}}"
                   data-text_title="{{$text->title}}"
                   data-text_lang="{{$text->lang_id}}"
                   data-translate_to_lang_id="{{$text->pivot->translate_to_lang_id}}">

                    <i class="icofont-ui-edit"></i> Edit
                </a>

                <a class="btn btn-primary text-light noradius" href="{{route('reader_delete_text', $text->id)}}">
                    <i class="icofont-ui-delete"></i> Delete
                </a>
            </div>

        </div>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection