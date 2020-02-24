<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">

    <title>WexLang</title>

</head>
<body>


<div class="container-fluid">

    <!-- HEADER START-->
    <header class="row border-bottom sticky-top header">

        <div class="container align-self-center nopadding">

            <div class="row align-items-center">

                <div class="col-md-12 col-lg-2">
                    <a href="/" class="logo">
                        WexLang
                    </a>
                </div>

                <div class="col-md-12 col-lg-auto nav-left">

                    <div class="row align-items-center">

                        {{--LANGUAGE DROPDOWN --}}

                        <div class="col-auto">

                            {{--                        <div class="dropdown">--}}
                            {{--                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="lang_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}

                            {{--                                @php $locale = session()->get('locale'); @endphp--}}

                            {{--                                @switch($locale)--}}
                            {{--                                    @case('en')--}}
                            {{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(0)['code'] .'.svg')}}" class="text_flag" alt="">--}}
                            {{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
                            {{--                                    @break--}}
                            {{--                                    @case('ru')--}}
                            {{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(1)['code'] .'.svg')}}" class="text_flag" alt="">--}}
                            {{--                                    {{\App\Config\Lang::get(75)['title']}}--}}
                            {{--                                    @break--}}
                            {{--                                    @default--}}
                            {{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(0)['code'] .'.svg')}}" class="text_flag" alt="">--}}
                            {{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
                            {{--                                @endswitch--}}

                            {{--                            </a>--}}

                            {{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lang_dropdown">--}}
                            {{--                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(21)['code'])}}">--}}
                            {{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(21)['code'] .'.svg')}}" class="text_flag" alt="">--}}
                            {{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
                            {{--                                </a>--}}
                            {{--                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(75)['code'])}}">--}}
                            {{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(75)['code'] .'.svg')}}" class="text_flag" alt="">--}}
                            {{--                                    {{\App\Config\Lang::get(75)['title']}}--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>

    <!-- HEADER END-->


    <!-- MAIN CONTENT START-->
    <main class="row">

        <div class="container">

            <div class="row">

                <!--LEFT SIDEBAR START-->
                <aside class="col-3 sidebar">

                    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
                        <span>{{__('Reader')}}</span>
                    </h4>

                    <div class="list-group list-group-flush">
                        <a href="{{route('texts')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-book"></i> {{__('My Texts')}}</a>
                        <a href="{{route('add_text_page')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-plus-square"></i> {{__('Add text')}}</a>
                    </div>


                    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
                        <span>{{__('Words')}}</span>
                    </h4>

                    <div class="list-group list-group-flush">
                        <a href="{{route('words')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-file-text"></i> {{__('My words')}}</a>
                    </div>

                    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
                        <span>{{__('Settings')}}</span>
                    </h4>

                    <div class="list-group list-group-flush">
                        <a href="" class="list-group-item list-group-item-action bg-light"><i class="icofont-file-text"></i> {{__('Upload dictionary')}}</a>
                    </div>

                </aside>
                <!--LEFT SIDEBAR END-->

                <div class="col reader_main_content">

                    @yield('content')

                </div>

            </div>
        </div>

    </main>
    <!-- MAIN CONTENT END-->

    {{--FOOTER START--}}
    <div class="row">

        <footer class="container-fluid footer">

            <div class="container">
                <div class="row text-white">

                    <div class="col">
                        <p>© 2019 WexLang <br> All Rights Reserved</p>
                    </div>

                    <div class="col ">
                        <b>Contacts</b><br>
                        <a href="mailto:predewill@gmail.com" class="text-white">predewill@gmail.com</a>

                    </div>

                    <div class="col">
                        <ul>
                            <li><a href="#" class="text-white">Facebook</a></li>
                            <li><a href="https://vk.com/wexlang" class="text-white">VK</a></li>
                            <li><a href="https://twitter.com/predewill" class="text-white">Twitter</a></li>
                        </ul>
                    </div>

                    <div class="col">

                    </div>

                </div>
            </div>

        </footer>

    </div>
    {{--FOOTER END--}}

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.js"></script>


<!-- App JavaScript -->
<script src="{{asset('js/reader.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>


@yield('js')

</body>
</html>
