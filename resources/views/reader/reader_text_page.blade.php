@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="col-2 bg-light nopadding pl-2">

            <div class="position-fixed">

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>Text</span>
                </h4>
                <hr>

                <div>
                    <p>
                        Text language:
                        <img src="{{asset('img/flags/'. \App\Config\Lang::get($text_lang_id)['code'] .'.svg')}}" class="text_flag" alt="">
                        <i class="text-muted">({{\App\Config\Lang::get($text_lang_id)['title']}})</i>
                    </p>
                    <p>
                      Translate to:
                      <img src="{{asset('img/flags/'. \App\Config\Lang::get($translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt="">
                      <i class="text-muted">({{\App\Config\Lang::get($translate_to_lang_id)['title']}})</i>
                    </p>
                </div>



                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>Words</span> <span style="font-size: 16px">(Click to translate)</span>
                </h4>
                <hr>

                <p><mark class="study">word</mark> - to study words</p>
                <p><mark class="unknown">word</mark> - unknown words</p>
                <p><mark>word</mark> - known words</p>

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>Options</span>
                </h4>
                <hr>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="h_known" checked>
                    <label class="custom-control-label" for="h_known">Highlight to study words</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="h_unknown" checked>
                    <label class="custom-control-label" for="h_unknown">Highlight unknown words</label>
                </div>

                <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                    <span>Other</span>
                </h4>
                <hr>

                <div style="Word-Wrap: break-word; max-width: 300px;">
                    Select text and press
                    <span style="font-size: 20px; border: 1px solid gray; width: 30px; display: inline-block; text-align: center; border-radius: 20%;"><b>T</b></span> to
                    translate selected text in google translate
                </div>
                <hr>
                <div>
                    <a class="btn btn-primary noradius w-100 mr-5 mt-3" href="{{route('qa_add_question')}}@if(app('request')->get('public') == 1)?public=1 @endif" target="_blank"><b>ASK QUESTION</b></a>
                </div>



            </div>


        </div>

        {{-- CONTENT START--}}
        <div class="col-8">

            <div class="row justify-content-md-center mt-3">

                <div class="col-md-auto">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><b>TEXT</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><b>WORDS</b></a>
                        </li>
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><b>QUESTIONS</b></a>--}}
                        {{--</li>--}}
                    </ul>

                </div>
            </div>


            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="page_text_wrapper">{!! $pageContent !!}</div>

                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <h1>Unique words on this page ({{count($words)}})</h1>

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

                {{--<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">--}}
                    {{--3--}}
                {{--</div>--}}

            </div>

            <div class="mt-3">
                {{$pages->links()}}
            </div>


        </div>


        <div class="col-2 bg-light" id="rs">

            <div class="position-fixed">

                <div>
                    <span style="font-size:30px" id="rs_word">Word</span>
                    <span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>
                </div>


                <hr>

                <div>
                    <b>Translation:</b>
                </div>

                <textarea id="rs_word_translation" cols="30" rows="3">word translation</textarea>



                <div id="rs_mark_known_wrapper">
                    <hr>
                    <b>Mark this word as known:</b> <br>
                    <button type="button" id="rs_mark_as_known_btn" class="btn btn-success btn-sm"
                            data-lang_id="{{$text_lang_id}}"
                            data-translate_to_lang_id = "{{$translate_to_lang_id}}"
                            data-word=""
                            data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                </div>


                <hr>

                <div class="pr-3 pt-3">

                    <a href="#" class="btn btn-primary w-100 mb-2" id="gt_btn">Translate in Google</a>

                    <a href="#" class="btn btn-primary w-100 mb-2" id="yt_btn">Translate in Yandex</a>
                </div>





            </div>

        </div>

    </main>



    <script type="text/javascript">

        var text_lang_code = "<?php echo \App\Config\Lang::get($text_lang_id)['code'] ?>";

        var text_translate_to_lang_code = "<?php echo \App\Config\Lang::get($translate_to_lang_id)['code'] ?>";

    </script>







    @endsection