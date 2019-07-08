@extends('layouts.main')

@section('main')


    <p>{{$question->title}}</p>

    <p>{{$question->content}}</p>

    <hr>

    <b>answers</b>

    @foreach($answers as $answer)

        <p>{{$answer->content}}</p>
    @endforeach


    <hr>


    <p>add answer</p>
    <form action="{{route('qa_add_answer')}}" method="post">
        @csrf

        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        <input type="hidden" name="question_id" value="{{$question->id}}">
        <input type="text" name="content">
        <button type="submit">send</button>
    </form>

@endsection