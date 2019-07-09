@extends('layouts.reader.reader_layout')

@section('reader_content')

    <h1>MY WORDS</h1>

    <h2>TOTAL WORDS - {{ $totalWords }}</h2>
    <h2>KNOWN WORDS - {{ $totalKnownWords }} </h2>
    <h2>NEW WORDS TO STUDY - {{ $totalNewWords }} </h2>

    <p><a href="{{route('reader_new_words')}}">NEW WORDS</a></p>
    <p><a href="{{route('reader_known_words')}}">KNOWN WORDS</a></p>

    @foreach($words as $word)



        <p>word - {{$word->word}} </p>
        <p>state - {{$word->pivot->state}} </p>
        <p>google translation - {{$word->googleTranslation->translation}}</p>

        <p>community  translation -
            @foreach($word->communityTranslations as $translation)
                <span> {{ $translation->translation }} </span> ,
            @endforeach
        </p>

        <hr>

    @endforeach

    {{$words->links()}}

@endsection

