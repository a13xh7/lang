@extends('layouts.reader')

@section('reader_main')

    @if(count($texts) === 0)

        <a href="">add text</a>

    @endif

    @foreach($texts as $text)

        <div class="text_wrapper">
            <div class="text_title"> <b>{{$text->lang->eng_title}}</b> <b>{{$text->settings()->lang->eng_title}}</b>  - {{$text->title}}</div>
            <p>Pages: {{ $text->total_pages}} / Current page: {{ $text->settings()->current_page }}</p>
            <p>Symbols: {{ $text->total_symbols}} | Total words: {{ $text->total_words}} |  Unique words: {{ $text->unique_words}}</p>
            <p>Known words - 11 (percent) | Unknown words - 11(percent)</p>
            <p>PROGRESS = {{ $text->total_pages  / 100 * $text->settings()->current_page }}%</p>

            <p>
                <a href="{{route('reader_read_text_page', $text->id)}}?page={{$text->current_page}}">READ</a> |
                <button class="w3-button w3-black"  data-text-id="{{$text->id}}" data-language-id="{{$text->language_id}}" onclick="document.getElementById('id01').style.display='block'">EDIT</button>
               | <a href="{{route('reader_delete_text', $text->id)}}">DELETE</a>
                | <a href="{{ route('reader_text_stats', $text->id) }}">FULL_INFO</a>
            </p>

        </div>








    @endforeach


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
