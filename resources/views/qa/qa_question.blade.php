@extends('layouts.qa.qa_layout')

@section('qa_content')



    <h1><b>{{$question->title}}</b></h1>

    <div class="row question_info">

        <div class="col">
            <img src="{{ (new \App\Services\Avatar\LetterAvatar($question->user->name, 'circle', 35)) }}" alt="">
            <b> <span class="user_name">{{$question->user->name}}</span></b><span class="text-muted small">, {{$question->created_at->diffForHumans()}},</span>
            <span class="text-muted small">{{$question->views}} views</span>
        </div>

        <div class="col col-auto">

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

    <div class="question_content">
        {!!  $question->content !!}


        <div align="right">

            @auth()

                @if($question->user_id == auth()->user()->id)
                    <a class="btn btn-primary noradius pl-5 pr-5 mt-3" href="{{route('qa_edit_question_page', $question->id)}}"><b>EDIT</b></a>
                @endif

            @endauth


        </div>
    </div>


    <div class="question_answers">

      <div class="h3 answers_title">{{$question->answers()->count()}} answers</div>


        @foreach($answers as $answer)

            <div class="answer_wrapper">

                <div class="answer_info mb-3">

                    <img src="{{ (new \App\Services\Avatar\LetterAvatar($answer->user->name, 'circle', 35)) }}" alt="">


                    <b><span class="user_name">{{$answer->user->name}}</span></b><span class="text-muted small">, {{$question->created_at->diffForHumans()}}</span>
                </div>

                <div class="answer_content">{!! $answer->content !!} </div>
            </div>


        @endforeach


    </div>


    @if($showAnswerForm)

        <div class="answer_form">
            <p class="h4">Your Answer</p>
            <form action="{{route('qa_add_answer')}}" method="post">
                @csrf

                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                <input type="hidden" name="question_id" value="{{$question->id}}">

                <input id="x" type="hidden" name="content">
                <trix-editor input="x" class="trix"></trix-editor>

                <button type="submit" class="btn w-100 btn-primary noradius" style="margin-bottom: 30px; margin-top: 10px"><b>ADD</b></button>
            </form>

        </div>

    @else

        @guest()
        <div class="answer_form">
            <p><b>Login to add answer</b></p>
        </div>
        @endguest
    @endif






@endsection
