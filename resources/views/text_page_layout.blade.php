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

    <title>WexLang</title>
</head>
<body>

<!-- Bootstrap NavBar -->
<nav class="navbar navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="{{route('texts')}}">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span>WexLang</span>
    </a>


</nav>
<!-- NavBar END -->


@php

    $textLanguageFlag = 'img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] . '.svg';
    $textLanguageTitle = \App\Config\Lang::get($text->lang_id)['title'];

    $translateToLangFlag = 'img/flags/'. \App\Config\Lang::get($text->translate_to_lang_id)['code'] . '.svg';
    $translateToLangTitle = \App\Config\Lang::get($text->translate_to_lang_id)['title'];

    $toStudyCheckboxState = \Illuminate\Support\Facades\Cookie::get('h_unknown') == 1 || \Illuminate\Support\Facades\Cookie::get('h_unknown') == null ? "checked" : "";
    $unknownCheckboxState = \Illuminate\Support\Facades\Cookie::get('h_unknown') == 1 || \Illuminate\Support\Facades\Cookie::get('h_unknown') == null ? "checked" : "";

@endphp


<!-- Bootstrap row -->
<div class="row" id="body-row">

    <!-- LEFT SIDEBAR START -->
    <div class="sidebar-expanded text_page_sidebar col-2">

        <div class="position-fixed">

            <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                <span>{{__('Text')}}</span>
            </h4>

            <hr>

            <div>
                <p>
                    {{__('Text language')}}:
                    <img src="{{asset($textLanguageFlag)}}" class="text_flag" alt="">
                    <i class="text-muted">({{$textLanguageTitle}})</i>
                </p>
                <p>
                    {{__('Translate to')}}:
                    <img src="{{asset($translateToLangFlag)}}" class="text_flag" alt="">
                    <i class="text-muted">({{$translateToLangTitle}})</i>
                </p>
            </div>

            <h4 class="sidebar-heading mt-4 mb-1 text-muted">
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

            <h4 class="sidebar-heading mt-4 mb-1 text-muted">
                <span>{{__('Other')}}</span>
            </h4>

            <hr>

            <div style="Word-Wrap: break-word; max-width: 300px;">
                {{__('Select text and press')}}
                <span style="font-size: 20px; border: 1px solid gray; width: 30px; display: inline-block; text-align: center; border-radius: 20%;"><b>T</b></span> {{__('to translate selected text in Google Translate')}}
            </div>

        </div>
    </div>
    <!-- LEFT SIDEBAR END -->

    <!-- MAIN -->
    <div class="col py-3">

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

<script type="text/javascript">
    var text_lang_code = "<?php echo \App\Config\Lang::get($text_lang_id)['code'] ?>";
    var text_translate_to_lang_code = "<?php echo \App\Config\Lang::get($translate_to_lang_id)['code'] ?>";
</script>

</body>
</html>

