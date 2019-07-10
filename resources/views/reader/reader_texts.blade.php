@extends('layouts.reader.reader_layout')

@section('reader_content')

  <h1>My texts</h1>

    @foreach($texts as $text)


        <div class="text_item border-bottom">

            <span class="text_title">
                <b>{{$text->lang->eng_title}}</b> <b>{{$text->settings()->lang->eng_title}}</b>
                <a class="h4" href="">{{$text->title}}</a>
            </span>

            <div class="text_stats">
                <span>Symbols: <b>{{ $text->total_symbols}}</b> <b>|</b> Words: <b>{{ $text->total_words}}</b> <b>|</b> Unique words: <b>{{ $text->unique_words}}</b> <b>|</b> Known words: <b>768</b> <b>|</b> Unknown Words: <b>9993</b></span>
            </div>

            <div class="text_pages_info">
                <span>Pages: <b>{{ $text->total_pages}}</b> / Current page: <b>{{ $text->settings()->current_page }}</b></span>
            </div>

            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $text->total_pages  / 100 * $text->settings()->current_page}}%;" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100">
                    {{--{{ $text->total_pages  / 100 * $text->settings()->current_page }}--}}
                </div>
            </div>

            <div class="text_controls">

                <a class="btn btn-primary text-light noradius" href="{{route('reader_read_text_page', $text->id)}}?page={{$text->current_page}}">
                    <i class="icofont-read-book"></i> Read
                </a>

                <a class="btn btn-primary text-light noradius" href="{{ route('reader_text_stats', $text->id) }}">
                    <i class="icofont-info-square"></i> Full Info
                </a>

                <a class="btn btn-primary text-light noradius"><i class="icofont-ui-edit"></i> Edit</a>

                <a class="btn btn-primary text-light noradius" href="{{route('reader_delete_text', $text->id)}}">
                    <i class="icofont-ui-delete"></i> Delete
                </a>
            </div>

        </div>

    @endforeach

    <br>
    {{ $texts->links() }}


@endsection



{{--<div id="id01" class="w3-modal">--}}
    {{--<div class="w3-modal-content">--}}
        {{--<div class="w3-container">--}}
            {{--<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>--}}


            {{--<form action=" {{route('reader_update_text')}} " method="POST">--}}
                {{--<p>title <input type="text"></p>--}}
                {{--<p>language id <input type="text"> </p>--}}

                {{--<button type="submit">Submit</button>--}}
            {{--</form>--}}


        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
