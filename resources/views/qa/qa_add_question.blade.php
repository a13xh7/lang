@extends('layouts.qa.qa_layout')

@section('qa_content')






        <h1 class="uc">{{__('Ask question')}}</h1>

        <form action="{{route('qa_add_question', ['text='. app('request')->get('text'), 'page='. app('request')->get('page')])}}" method="POST">
            @csrf

            <input type="hidden" name="text_id" value="0">

            <div class="form-group">
                <label for="lang_from">{{__('Question language (your native language)')}}</label>

                <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                                @if($questionsLanguage == $lang['id'])

                                selected

                                @endif
                        >
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">
                <label for="lang_to">{{__('Question about language (language you learn)')}}</label>

                <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                    @foreach(\App\Config\Lang::all() as $lang)

                        <option
                                value="{{$lang['id']}}"
                                data-subtext="{{$lang['eng_title']}}"
                                data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                                @if($questionsAboutLanguage == $lang['id'])

                                selected

                                @endif
                        >
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">
                <label for="title">{{__('Title')}}</label>

                <input type="text" class="form-control" name="title" id="title" placeholder="Question title" required>

            </div>

            <div class="form-group">

                <label for="question_content">{{__('Question')}}</label>

                <input id="x" type="hidden" name="content">
                <trix-editor input="x" class="trix"></trix-editor>

                {{--<textarea class="form-control" id="question_content" name="question_content" rows="10" required></textarea>--}}

            </div>

            <button type="submit" class="btn w-100 btn-primary noradius" style="margin-bottom: 30px;"><b>{{__('Send')}}</b></button>

        </form>






@endsection