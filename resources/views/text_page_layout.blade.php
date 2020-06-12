<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/icofont.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">

    <title>WexLang Reader 1.0</title>
</head>
<body>

@include("header")


@php

    $toStudyCheckboxState = \Illuminate\Support\Facades\Cookie::get('h_known') == 1 || \Illuminate\Support\Facades\Cookie::get('h_unknown') == null ? "checked" : "";
    $unknownCheckboxState = \Illuminate\Support\Facades\Cookie::get('h_unknown') == 1 || \Illuminate\Support\Facades\Cookie::get('h_unknown') == null ? "checked" : "";
    $clickOnNew = \Illuminate\Support\Facades\Cookie::get('new_to_known') == 1 ? "checked" : "";
//dd(\Illuminate\Support\Facades\Cookie::get('new_to_known'));
@endphp


<!-- Bootstrap row -->
<div class="row" id="body-row">

    <!-- LEFT SIDEBAR START -->
    <div class="sidebar-expanded text_page_sidebar col-2">

        <div class="position-fixed" style="width: 15%;">

            <a class="btn btn-primary text-light noradius w-100" href="{{route("texts")}}" onclick="showLoadingOverlay()">
                <b><< {{__("My texts")}}</b>
            </a>

            <hr>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="new_to_known" {{$clickOnNew}}>
                <label class="custom-control-label" for="new_to_known">Mark as known at click on new words (mark as to-study if disabled)</label>
            </div>

            <hr>

            <h4 class="sidebar-heading mt-2 mb-1 text-muted">
                <span>{{__('Words')}}</span> <br>
                <span style="font-size: 16px">({{__('Click to translate')}})</span>
            </h4>

            <hr>

            <p><mark>word</mark> - {{__('known words')}}</p>
            <p><mark class="study">word</mark> - {{__('to study words')}}</p>
            <p><mark class="unknown">word</mark> - {{__('unknown words')}}</p>

            <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                <span>{{__('Options')}}</span>
            </h4>

            <hr>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="h_known" {{$toStudyCheckboxState}}>
                <label class="custom-control-label" for="h_known">{{__('Highlight to study words')}}</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="h_unknown" {{$unknownCheckboxState}}>
                <label class="custom-control-label" for="h_unknown">{{__('Highlight unknown words')}}</label>
            </div>

            <hr>


            @if( preg_match("#words#", url()->current()) )

                <button type="button" id="mark_all_as_to_study_on_words_page" class="btn btn-warning mb-3"><b>{{__('Mark all as TO STUDY')}}</b></button>
                <br>
                <button type="button" id="mark_all_as_known_on_words_page" class="btn btn-success"><b>{{__('Mark all as KNOWN')}}</b></button>

            @else

                <button type="button" id="mark_all_as_to_study" class="btn btn-warning mb-3"><b>{{__('Mark all as TO STUDY')}}</b></button>
                <br>
                <button type="button" id="mark_all_as_known_btn" class="btn btn-success"><b>{{__('Mark all as KNOWN')}}</b></button>

            @endif


            </div>
    </div>
    <!-- LEFT SIDEBAR END -->

    <!-- MAIN -->
    <div class="col py-3">

        <div class="row justify-content-md-center mt-3">
            <div class="col-md-auto">
                <ul class="nav nav-pills mb-3" >

                    @php
                        $textActiveState = !preg_match("#words#", url()->current()) ? "active" : "";
                        $wordsActiveState = preg_match("#words#", url()->current()) ? "active" : "";
                    @endphp

                    <li class="nav-item">
                        <a class="nav-link {{$textActiveState}}" href="{{route('read_text_page', $text_id)}}?page={{$current_page}}"><b class="uc">{{__('Text')}}</b></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{$wordsActiveState}}" href="{{route('text_page_words', $text_id)}}"><b class="uc">{{__('Words')}}</b></a>
                    </li>
                </ul>
            </div>
        </div>



        @yield('content')

    </div>
    <!-- Main Col END -->


    <!-- RIGHT SIDEBAR START -->
    <div class="sidebar-expanded text_page_sidebar col-2">

        <div class="position-fixed">

            <div>
                <span style="font-size:30px" id="rs_word">{{__('Word')}}</span>
                <span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">{{__('To study')}}</span>
            </div>

            <hr>

            <div>
                <b>{{__('Translation')}}:</b>
            </div>

            <textarea id="rs_word_translation" cols="30" rows="10">{{__('word translation')}}</textarea>

            <div id="rs_mark_known_wrapper">
                <hr>

                <button type="button" id="rs_save_translation_btn" class="btn btn-info">{{__('Save Translation')}}</button>

                <hr>

                <b>{{__('Mark this word as')}}:</b>
                <br>
                <span class="text-muted">{{__('New words get "To study" state by default')}}</span>
                <br>

                <button type="button" id="rs_mark_as_known_btn" class="btn btn-success btn-sm" data-state="{{\App\Config\WordConfig::KNOWN}}">{{__('Known')}}</button>

                <button type="button" id="rs_mark_as_to_study_btn" class="btn btn-warning btn-sm" data-state="{{\App\Config\WordConfig::TO_STUDY}}">{{__('To study')}}</button>


            </div>

            <hr>

            <div class="pr-3 pt-3">
                <a href="#" class="btn btn-primary w-100 mb-2" id="gt_btn">{{__('Translate in Google')}}</a>
                <a href="#" class="btn btn-primary w-100 mb-2" id="yt_btn">{{__('Translate in Yandex')}}</a>
            </div>

        </div>
    </div>
    <!-- RIGHT SIDEBAR END -->

</div>
<!-- body-row END -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('js/popper.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-select.min.js')}}"></script>

<!-- App JavaScript -->
<script src="{{asset('js/reader.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>

</body>
</html>

