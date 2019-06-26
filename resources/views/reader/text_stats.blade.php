@extends('layouts.reader')

@section('content')

<h1>FULL TEXT INFO</h1>

    <div class="w3-border-bottom">

        <p> <span>language_Icon </span>{{$text->title}}</p>
        <p>Total pages - {{ $text->total_pages}}</p>
        <p>Current page - {{ $text->current_page}}</p>
        <p>Total words - {{ $text->textInfo->total_words}}</p>
        <p>known words - {{$text->textInfo->known_words}}</p>
        <p>unknown words - {{$text->textInfo->unknown_words}}</p>


    </div>







@endsection