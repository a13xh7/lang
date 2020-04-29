<nav class="navbar navbar-dark bg-dark fixed-top" style="padding-top: 0; padding-bottom: 0;">

    <a class="navbar-brand" href="{{route('texts')}}">

        <img src="{{asset("img/logo.svg")}}" width="30" height="30" class="d-inline-block align-top" alt="">
        <span class="mr-3">WexLang Reader</span>


        <img src="{{asset('img/flags/'. \App\Config\Config::getLearnedLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getLearnedLangData()['title']}})</i>
        <span class="q_lang_arrow">⟶</span>
        <img src="{{asset('img/flags/'. \App\Config\Config::getKnownLangData()['code'] . '.svg')}}" class="text_flag" alt=""> <i class="text-small">({{\App\Config\Config::getKnownLangData()['title']}})</i>

    </a>




    <div>

        <form class="form-inline btn" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="padding: 0; margin: 0; padding-top: 7px;">
            <input type="hidden" name="cmd" value="_s-xclick" />
            <input type="hidden" name="hosted_button_id" value="UZVJNLNS3TEYL" />
            <input type="image" src="{{asset("img/paypal2.png")}}" width="204px" height="40px" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" src="https://www.paypal.com/en_MD/i/scr/pixel.gif" width="1" height="1" />
        </form>

        <a href="https://www.patreon.com/bePatron?u=33315836" target="_blank">
            <img src="{{asset("img/patreon.png")}}" height="40px">
        </a>


{{--        <a href="https://www.patreon.com/bePatron?u=33315836" target="_blank" class="btn">--}}
{{--            <i class="icofont-facebook icofont-2x" style="color: white; vertical-align: middle;"></i>--}}
{{--        </a>--}}

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
