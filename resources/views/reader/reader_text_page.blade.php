@extends('layouts.main.main_layout')

@section('seo')

    <title>{{__('Reader')}} - {{$page->text->title}}</title>

@endsection


@section('main_content')

    <main class="row">

        <div class="col-2 bg-light nopadding pl-2">

            <div class="position-fixed">

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>{{__('Text')}}</span>
                </h4>
                <hr>

                <div>
                    <p>
                        {{__('Text language')}}:
                        <img src="{{asset('img/flags/'. \App\Config\Lang::get($text_lang_id)['code'] .'.svg')}}" class="text_flag" alt="">
                        <i class="text-muted">({{\App\Config\Lang::get($text_lang_id)['title']}})</i>
                    </p>
                    <p>
                        {{__('Translate to')}}:
                      <img src="{{asset('img/flags/'. \App\Config\Lang::get($translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt="">
                      <i class="text-muted">({{\App\Config\Lang::get($translate_to_lang_id)['title']}})</i>
                    </p>
                </div>



                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>{{__('Words')}}</span> <br>
                    <span style="font-size: 16px">({{__('Click to translate')}})</span>
                </h4>
                <hr>

                <p><mark class="study">word</mark> - {{__('to study words')}}</p>
                <p><mark class="unknown">word</mark> - {{__('unknown words')}}</p>
                <p><mark>word</mark> - {{__('known words')}}</p>

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>{{__('Options')}}</span>
                </h4>
                <hr>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="h_known"

                           @if(\Illuminate\Support\Facades\Cookie::get('h_known') == 1 || \Illuminate\Support\Facades\Cookie::get('h_known') == null)
                           checked
                           @endif
                    >
                    <label class="custom-control-label" for="h_known">{{__('Highlight to study words')}}</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="h_unknown"

                        @if(\Illuminate\Support\Facades\Cookie::get('h_unknown') == 1 || \Illuminate\Support\Facades\Cookie::get('h_unknown') == null)
                        checked
                        @endif
                    >
                    <label class="custom-control-label" for="h_unknown">{{__('Highlight unknown words')}}</label>
                </div>

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>{{__('Other')}}</span>
                </h4>
                <hr>

                <div style="Word-Wrap: break-word; max-width: 300px;">
                    {{__('Select text and press')}}
                    <span style="font-size: 20px; border: 1px solid gray; width: 30px; display: inline-block; text-align: center; border-radius: 20%;"><b>T</b></span> {{__('to translate selected text in Google Translate')}}
                </div>
                <hr>
                <div>

                    <?php


                    if( app('request')->get('public') == 1 ) {
                        $urlGetParam = "?text=". $page->text->id . '&page=' . $page->page_number;
                    } else {
                        $urlGetParam = '';
                    }

                    ?>


                    @if(app('request')->get('public') == 1)
                    <a class="btn btn-primary noradius w-100 mr-5 mt-3" href="{{route('qa_add_question')}}{{$urlGetParam}}" target="_blank"><b class="uc">{{__('Ask question')}}</b></a>
                    @endif

                </div>



            </div>


        </div>

        {{-- CONTENT START--}}
        <div class="col-8">

            <div class="row justify-content-md-center mt-3">

                <div class="col-md-auto">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><b class="uc">{{__('Text')}}</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><b class="uc">{{__('Words')}}</b></a>
                        </li>


                        @if(app('request')->get('public') == 1)

                            <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><b class="uc">{{__('Questions')}} ({{$questions->count()}})</b></a>
                            </li>

                        @endif



                    </ul>

                </div>
            </div>


            <div class="tab-content" id="pills-tabContent">

                {{-- PAGE CONTENT START--}}
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="page_text_wrapper">{!! $pageContent !!}</div>

                    <div class="mt-3">
                        {{$pages->links()}}
                    </div>

                </div>
                {{-- PAGE CONTENT END--}}

                {{-- PAGE WORDS START--}}
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <h1>{{__('Unique words on this page')}} ({{count($words)}})</h1>

                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width:20%">State</th>
                            <th scope="col" style="width:25%">Word</th>
                            <th scope="col" style="width:30%">Translation</th>
                            <th scope="col" style="width:25%">Usage frequency</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($words as $word)

                            <tr>
                                <td>

                                    @if(!in_array($word[0], $knownWords))
                                        <button type="button" class="btn btn-warning btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text_lang_id}}" data-translate_to_lang_id="{{$translate_to_lang_id}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                                        <button type="button" class="btn btn-success btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text_lang_id}}" data-translate_to_lang_id="{{$translate_to_lang_id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>

                                    @else


                                        @if($myWords->where('word', $word[0])->first()->pivot->state == \App\Config\WordConfig::TO_STUDY)
                                            <span class="badge badge-warning h4">To study</span>
                                        @else
                                            <span class="badge badge-success h4">Known</span>
                                        @endif

                                    @endif


                                </td>

                                <td>{{$word[0]}}</td>

                                <td>

                                    @if($myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first() != null)


                                        @if($myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first()->googleTranslation != null)
                                            {{$myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first()->googleTranslation->translation}}
                                        @endif


                                    @endif

                                </td>

                                <td>{{$word[1]}} <span class="small text-muted">({{$word[2]}}%)</span> </td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>

                </div>
                {{-- PAGE WORDS END--}}


                {{--QUESTION ON THIS PAGE START--}}

                @if(app('request')->get('public') == 1)

                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                        @foreach($questions as $question)


                            <div class="row question_wrapper">

                                <div class="question_content col-10">
                                    <div class="question_title"><a href="{{route('qa_question', $question->id)}}" class="h3" target="_blank">{{$question->title}}</a></div>
                                    <div><span class="text-muted small user_name">{{$question->user->name}}, {{$question->created_at->diffForHumans()}}</span>  <span class="text-muted small">-  {{$question->views}} views</span></div>
                                </div>

                                <div class="question_answers_count col">
                                    <span class="h1 text-muted">{{$question->answers()->count()}}</span> <br>
                                    <span class="text-muted small">answers</span>
                                </div>
                            </div>
                            <hr>



                        @endforeach

                            {{--<div class="mt-3">--}}
                            {{--{{$questions->links()}}--}}
                            {{--</div>--}}

                    </div>



                @endif
                {{--QUESTION ON THIS PAGE END--}}


            </div>



        </div>


        <div class="col-2 bg-light" id="rs">

            <div class="position-fixed">

                <div>
                    <span style="font-size:30px" id="rs_word">{{__('Word')}}</span>
                    <span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">{{__('To study')}}</span>
                </div>


                <hr>

                <div>
                    <b>{{__('Translation')}}:</b>
                </div>

                <textarea id="rs_word_translation" cols="30" rows="3">{{__('word translation')}}</textarea>



                <div id="rs_mark_known_wrapper">
                    <hr>
                    <b>{{__('Mark this word as known')}}:</b> <br>
                    <button type="button" id="rs_mark_as_known_btn" class="btn btn-success btn-sm"
                            data-lang_id="{{$text_lang_id}}"
                            data-translate_to_lang_id = "{{$translate_to_lang_id}}"
                            data-word=""
                            data-state="{{\App\Config\WordConfig::KNOWN}}">{{__('Known')}}</button>
                </div>


                <hr>

                <div class="pr-3 pt-3">

                    <a href="#" class="btn btn-primary w-100 mb-2" id="gt_btn">{{__('Translate in Google')}}</a>

                    <a href="#" class="btn btn-primary w-100 mb-2" id="yt_btn">{{__('Translate in Yandex')}}</a>
                </div>


            </div>

        </div>

    </main>



    <script type="text/javascript">

        var text_lang_code = "<?php echo \App\Config\Lang::get($text_lang_id)['code'] ?>";

        var text_translate_to_lang_code = "<?php echo \App\Config\Lang::get($translate_to_lang_id)['code'] ?>";

    </script>







    @endsection

@section('js')
    <script src="{{asset('js/reader_text_page.js')}}"></script>
@endsection
