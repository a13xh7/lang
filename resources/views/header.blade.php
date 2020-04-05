<nav class="navbar navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="{{route('texts')}}">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span>WexLang</span>

    </a>

    {{--    <ul class="navbar-nav">--}}
    {{--        <li class="nav-item">--}}
    {{--            <a class="nav-link" href="#">Home</a>--}}
    {{--        </li>--}}
    {{--    </ul>--}}

    <div style="color: white;">
        <img src="{{asset('img/flags/'. \App\Config\Config::getLearnedLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getLearnedLangData()['title']}})</i>
        <span class="q_lang_arrow">⟶</span>
        <img src="{{asset('img/flags/'. \App\Config\Config::getKnownLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getKnownLangData()['title']}})</i>
    </div>

    <script>
        learned_lang_code = "{{\App\Config\Config::getLearnedLangData()['code']}}";
        known_lang_code = "{{\App\Config\Config::getKnownLangData()['code']}}";
    </script>

</nav>
