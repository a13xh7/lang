@extends('layouts.reader')

@section('content')

    {{--<h1>MY WORDS</h1>--}}
    {{--<h2>TOTAL WORDS I KNOW - {{ $totalWords }}</h2>--}}

    <p><a href="{{route('reader_new_words')}}">NEW WORDS</a></p>
    <p><a href="{{route('reader_known_words')}}">KNOWN WORDS</a></p>

    {{--@foreach($words as $word)--}}

        {{--<p>{{$word->word}} - {{$word->translation}}</p>--}}

    {{--@endforeach--}}

    {{$words->links()}}

@endsection

