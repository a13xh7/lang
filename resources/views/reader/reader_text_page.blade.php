@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="col-2 bg-light ">

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
                    <span>Words</span>
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
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Highlight to study words</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Highlight unknown words</label>
                </div>

                translation mode - replace

                <p>select text and press T to translate</p>
                <hr>


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
        {{-- CONTENT END--}}












            {{--<div style="white-space: pre-wrap;">--}}
            {{--<div class="page_text_wrapper">--}}
                {{--{!! $pageContent !!}--}}
            {{--</div>--}}

        {{--</div>--}}

        <div class="col-2 bg-light">
            translation and wor settings
        </div>

    </main>










    @endsection