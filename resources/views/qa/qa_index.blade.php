@extends('layouts.qa.qa_layout')

@section('qa_content')

    <h2><a href="{{route('qa_add_question_page')}}">ADD</a></h2>

    @foreach($questions as $question)

        <div class="row question_wrapper">

            <div class="question_content col-10">
                <div class="question_title"><a href="{{route('qa_question', $question->id)}}" class="h3">{{$question->title}}</a></div>
                <div><span class="text-muted small">{{$question->created_at->diffForHumans()}}</span>  <span class="text-muted small">-  {{$question->views}} views</span></div>

            </div>

            <div class="question_answers_count col">
                <span class="h1 text-muted">{{$question->answers()->count()}}</span> <br>
                <span class="text-muted small">answers</span>
            </div>
        </div>
        <hr>

    @endforeach
    

@endsection