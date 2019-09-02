<header class="row border-bottom sticky-top header">

    <div class="container align-self-center nopadding">

        <div class="row align-items-center">

            <div class="col-md-12 col-lg-2">
                <a href="/" class="logo">
                    WexLang
                    {{--<img src="https://2code.info/demo/themes/Discy/Main/wp-content/themes/discy/images/logo.png" alt="">--}}
                </a>
            </div>

            <nav class="col-md-12 col-lg header-menu">

                @auth
                    <a href="{{ route('reader_texts') }}">{{__('READER')}}</a>
                @endauth

                @guest
                    <a href="{{ route('reader_landing') }}">{{__('READER')}}</a>
                @endguest

                @auth
                    <a href="{{ route('rt_my_texts') }}">{{__('Read Together')}}</a>
                @endauth

                @guest
                    <a href="{{ route('rt_landing') }}">{{__('Read Together')}}</a>
                @endguest


                <a href="{{route('qa_index')}}">{{__('Q & A')}}</a>

            </nav>

            <div class="col-md-12 col-lg-auto nav-left">


                <div class="row align-items-center">

                    {{--SITE LANGUAGE DROPDOWN --}}

                    <div class="col-auto">

                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="lang_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                @php $locale = session()->get('locale'); @endphp

                                @switch($locale)
                                    @case('en')
                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(21)['code'] .'.svg')}}" class="text_flag" alt="">
                                    {{\App\Config\Lang::get(21)['title']}}
                                    @break
                                    @case('ru')
                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(75)['code'] .'.svg')}}" class="text_flag" alt="">
                                    {{\App\Config\Lang::get(75)['title']}}
                                    @break
                                    @default
                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(21)['code'] .'.svg')}}" class="text_flag" alt="">
                                    {{\App\Config\Lang::get(21)['title']}}
                                @endswitch

                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lang_dropdown">
                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(21)['code'])}}">
                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(21)['code'] .'.svg')}}" class="text_flag" alt="">
                                    {{\App\Config\Lang::get(21)['title']}}
                                </a>
                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(75)['code'])}}">
                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(75)['code'] .'.svg')}}" class="text_flag" alt="">
                                    {{\App\Config\Lang::get(75)['title']}}
                                </a>
                            </div>
                        </div>

                    </div>
                    {{--SITE LANGUAGE DROPDOWN --}}

                    {{-- BLOCK WITH LOGIN REGISTER BUTTONS AND USER AVATAR --}}
                    <div class="col">

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary noradius"><i class="icofont-login"></i> {{__('LOGIN')}} </a>

                            <a href="{{ route('register') }}" class="btn btn-primary noradius"><i class="icofont-user-alt-3"></i> {{__('REGISTER')}}</a>

                        @endguest

                        @auth

                            <div class="dropdown show">

                                <a class="header_user_name" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span>

                                    @php
                                        $avatar =  new \App\Services\Avatar\LetterAvatar(auth()->user()->name, 'circle', 35);

                                     echo "<img class='avatar' src='".$avatar."'/>"

                                    @endphp

                                    <span class="user_name" style="vertical-align: middle">{{auth()->user()->name}}</span>
                                </span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top: 10px;">
                                    <a href="{{route('main_user_settings')}}" class="dropdown-item"><i class="icofont-gear"></i> {{__('Settings')}}</a>
                                    <a href="{{ route('logout') }}" class="dropdown-item"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="icofont-logout"></i>{{__('Logout')}}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                        @endauth
                    </div>
                    {{-- BLOCK WITH LOGIN REGISTER BUTTONS AND USER AVATAR --}}

                </div>


            </div>

        </div>

    </div>

    <div class="container nopadding text-white" >
        <p>This site is for sale(<b>350$</b>) - <a href="mailto:predewill@gmail.com">predewill@gmail.com</a></p>
    </div>

</header>
