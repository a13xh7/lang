@extends('layouts.qa.qa_layout')

@section('qa_content')



    <div class="row mt-3 mb-1">
        <div class="col"><span class="h1" style="color: #606060">All Questions</span></div>
        <div class="col col-auto"> <a class="btn btn-primary noradius" href="{{route('qa_add_question_page')}}">ASK QUESTION</a></div>
    </div>
    <hr>


    <div class="q_lang_filter">

        <label for="lang_from">Question language</label>
        <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

            @foreach(\App\Config\Lang::all() as $lang)

                <option
                        value="{{$lang['id']}}"
                        data-subtext="{{$lang['eng_title']}}"
                        data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                </option>

            @endforeach

        </select>


        <label for="lang_to">Question about language</label>

            <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                    </option>

                @endforeach

            </select>

        <button type="submit" class="btn w-100 btn-primary noradius" style="margin: 15px 0;"><b>FILTER</b></button>

        <p><b>How to use filter:</b> </p>
        <p>Например - вы знаете русский и вы изучаете английский язык.</p>
        <p>Вы можете задать вопрос русскоязычным пользоавателям установив язык вопроса - русский</p>

    </div>



    @foreach($questions as $question)

        <div class="row question_wrapper">

            <div class="question_content col-10">
                <div class="question_title"><a href="{{route('qa_question', $question->id)}}" class="h3">{{$question->title}}</a></div>
                <div><span class="text-muted small">{{$question->user->name}}, {{$question->created_at->diffForHumans()}}</span>  <span class="text-muted small">-  {{$question->views}} views</span></div>
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