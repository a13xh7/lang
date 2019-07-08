@extends('layouts.main')

@section('main')

    <h2><a href="{{route('qa_add_question_page')}}">ADD</a></h2>

    @foreach($questions as $question)

        <p><a href="{{route('qa_question', $question->id)}}">{{$question->title}}</a></p>
        <p>views - {{$question->views}} </p>
        <hr>

    @endforeach
    

@endsection