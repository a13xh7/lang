@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="col-2 bg-light ">

            <p>ask question</p>

            <hr>

            translation mode - replace

            <hr>

            <p>color - to study words</p>
            <p>color - unknown words</p>
            <p>no color - known words</p>

            <hr>

            <p>checkbox - highlight to study words</p>
            <p>checkbox - highlight unknown words</p>

            <hr>

            <p>select text and press T to translate</p>
        </div>

        {{-- CONTENT START--}}
        <div class="col-7">

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

                    <div class="page_text_wrapper">
                        {!! $pageContent !!}
                    </div>

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

        </div>
        {{-- CONTENT END--}}












            {{--<div style="white-space: pre-wrap;">--}}
            {{--<div class="page_text_wrapper">--}}
                {{--{!! $pageContent !!}--}}
            {{--</div>--}}

        {{--</div>--}}

        <div class="col-3 bg-light">
            translation and wor settings
        </div>

    </main>






    {{$pages->links()}}



    @endsection