@extends('layouts.reader')

@section('reader_main')

<h1>FULL TEXT INFO</h1>

    <div class="w3-border-bottom">

        <p> <b>{{$text->lang->eng_title}}</b> <b>{{$text->settings()->lang->eng_title}}</b> </p>
        <P>title - {{$text->title}}</P>

        <p>Total pages - {{ $text->total_pages}}</p>
        <p>Current page - {{ $text->settings()->current_page }}</p>

        <p>Total symbols - {{ $text->total_symbols}}</p>

        <p>Total words - {{ $text->total_words}}</p>
        <p>Unique words - {{ $text->unique_words}}</p>

        <p>known words - 11 (percent)</p>
        <p>unknown words - 11(percent) </p>

    </div>

    <h2>WORDS</h2>

@foreach($words as $word => $usage)
    <p>{{$word}} - {{$usage}}</p>

@endforeach




@endsection