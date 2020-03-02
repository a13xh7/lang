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
<script src="{{asset('js/reader_text_page.js')}}"></script>

<script type="text/javascript">
    var text_lang_code = "<?php echo \App\Config\Lang::get($text_lang_id)['code'] ?>";
    var text_translate_to_lang_code = "<?php echo \App\Config\Lang::get($translate_to_lang_id)['code'] ?>";
</script>

</body>
</html>








{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <!-- Required meta tags -->--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <!-- Bootstrap CSS -->--}}
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
{{--    <!-- App CSS -->--}}
{{--    <link rel="stylesheet" href="{{ asset('css/style.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">--}}

{{--    <title>WexLang</title>--}}

{{--</head>--}}
{{--<body>--}}


{{--<div class="container-fluid">--}}

{{--    <!-- HEADER START-->--}}
{{--    <header class="row border-bottom sticky-top header">--}}

{{--        <div class="container align-self-center nopadding">--}}

{{--            <div class="row align-items-center">--}}

{{--                <div class="col-md-12 col-lg-2">--}}
{{--                    <a href="/" class="logo">--}}
{{--                        WexLang--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </header>--}}

{{--    <!-- HEADER END-->--}}


{{--    <!-- MAIN CONTENT START-->--}}
{{--    <main class="row">--}}

{{--        <div class="container-fluid">--}}

{{--            <div class="row">--}}


{{--                <div class="col reader_main_content">--}}

{{--                    @yield('content')--}}

{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </main>--}}
{{--    <!-- MAIN CONTENT END-->--}}



{{--</div>--}}

{{--<!-- Optional JavaScript -->--}}
{{--<!-- jQuery first, then Popper.js, then Bootstrap JS -->--}}
{{--<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>--}}

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/js/bootstrap-select.min.js"></script>--}}


{{--<!-- App JavaScript -->--}}
{{--<script src="{{asset('js/reader.js')}}"></script>--}}
{{--<script src="{{asset('js/js.cookie.js')}}"></script>--}}



{{--@yield('js')--}}

{{--</body>--}}
{{--</html>--}}
