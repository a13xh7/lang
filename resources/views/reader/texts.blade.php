@extends('layouts.reader')

@section('content')

    @if(count($texts) === 0)

        <a href="">add text</a>

    @endif

    @foreach($texts as $text)

        <div class="w3-border-bottom">

            <p> <span>language_Icon </span>{{$text->title}}</p>
            <p>Total pages - {{ $text->total_pages}}</p>
            <p>Current page - {{ $text->current_page}}</p>
            <p>Total words - {{ $text->textInfo->total_words}}</p>
            <p>known words - {{$text->textInfo->known_words}}</p>
            <p>unknown words - {{$text->textInfo->unknown_words}}</p>

            <p><button class="w3-button w3-black"  data-text-id="{{$text->id}}" data-language-id="{{$text->language_id}}" onclick="document.getElementById('id01').style.display='block'">EDIT</button></p>
            <p><a href="{{route('reader_delete_text', $text->id)}}">DELETE</a></p>
            <p><a href="{{ route('reader_text_stats', $text->id) }}">FULL_INFO</a></p>
        </div>

    @endforeach


    {{ $texts->links() }}


@endsection



<div id="id01" class="w3-modal">
    <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>


            <form action=" {{route('reader_update_text')}} " method="POST">
                <p>title <input type="text"></p>
                <p>language id <input type="text"> </p>

                <button type="submit">Submit</button>
            </form>


        </div>
    </div>
</div>
</div>