@extends('layouts.rt.rt_layout')

@section('rt_content')

    <h1 class="uc">{{__('My questions')}}</h1>


    @foreach($questions as $question)

        <div class="row question_wrapper">

            <div class="question_content col-10">
                <div class="question_title"><a href="{{route('qa_question', $question->id)}}" class="h3">{{$question->title}}</a></div>
                <div><span class="text-muted small">{{$question->created_at->diffForHumans()}}</span>  <span class="text-muted small">-  {{$question->views}} views</span></div>
                <div>



                    <img src="{{asset('img/flags/'. \App\Config\Lang::get($question->lang_id)['code'] .'.svg')}}" class="text_flag" alt="">
                    <span class="text-muted small">
                        {{\App\Config\Lang::get($question->lang_id)['title']}}
                        <i>({{\App\Config\Lang::get($question->lang_id)['eng_title']}})</i>
                    </span>

                    <span class="q_lang_arrow">&#10230;</span>

                    <img src="{{asset('img/flags/'. \App\Config\Lang::get($question->about_lang_id)['code'] .'.svg')}}" class="text_flag" alt="">
                    <span class="text-muted small">
                        {{\App\Config\Lang::get($question->about_lang_id)['title']}}
                        <i>({{\App\Config\Lang::get($question->about_lang_id)['eng_title']}})</i>
                    </span>



                </div>
            </div>

            <div class="question_answers_count col">
                <span class="h1 text-muted">{{$question->answers()->count()}}</span> <br>
                <span class="text-muted small">answers</span>
            </div>
        </div>
        <hr>

    @endforeach


    {{  $questions->links() }}

@endsection