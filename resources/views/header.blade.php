<nav class="navbar navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="{{route('texts')}}">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span class="mr-3">WexLang Reader</span>


        <img src="{{asset('img/flags/'. \App\Config\Config::getLearnedLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getLearnedLangData()['title']}})</i>
        <span class="q_lang_arrow">⟶</span>
        <img src="{{asset('img/flags/'. \App\Config\Config::getKnownLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getKnownLangData()['title']}})</i>

    </a>

    <div>
        <a href="https://www.patreon.com/bePatron?u=33315836" target="_blank">
            <img src="{{asset("img/patreon.png")}}" height="40px">
        </a>

        <a href="https://www.patreon.com/bePatron?u=33315836" target="_blank" class="btn">
            <i class="icofont-facebook icofont-2x" style="color: white; vertical-align: middle;"></i>
        </a>

        <a href="https://vk.com/wexlang" target="_blank" class="btn">
            <i class="icofont-vk icofont-2x" style="color: white; vertical-align: middle;"></i>
        </a>



    </div>



{{--    <div class="rounded-circle" style="background-color: red; width: 30px; height: 30px;">--}}
{{--        --}}
{{--    </div>--}}



    <script>
        learned_lang_code = "{{\App\Config\Config::getLearnedLangData()['code']}}";
        known_lang_code = "{{\App\Config\Config::getKnownLangData()['code']}}";
    </script>

</nav>
