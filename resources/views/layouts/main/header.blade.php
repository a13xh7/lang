<header class="row border-bottom sticky-top header">

    <div class="container align-self-center nopadding">

        <div class="row align-items-center">

            <div class="col-md-12 col-lg-2">
                <a href="/" class="logo">
                    {{--WEXLANG--}}
                    <img src="https://2code.info/demo/themes/Discy/Main/wp-content/themes/discy/images/logo.png" alt="">
                </a>
            </div>

            <nav class="col-md-12 col-lg header-menu">

                @auth
                    <a href="{{ route('reader_texts') }}">READER</a>
                @endauth

                @guest
                    <a href="{{ route('reader_landing') }}">READER</a>
                @endguest

                @auth
                    <a href="{{ route('rt_my_texts') }}">Read Together</a>
                @endauth

                @guest
                    <a href="{{ route('rt_landing') }}">Read Together</a>
                @endguest


                <a href="{{route('qa_index')}}">Q & A</a>

            </nav>

            <div class="col-md-12 col-lg-auto nav-left">

                @guest
                <a href="{{ route('login') }}" class="btn btn-primary noradius"><i class="icofont-login"></i> LOGIN</a>
                <a href="{{ route('register') }}" class="btn btn-primary noradius"><i class="icofont-user-alt-3"></i> REGISTER</a>
                @endguest

                @auth


                        <div class="dropdown show">



                            <a class="header_user_name" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span>

                                    @php

                                        $avatar =  new \App\Services\Avatar\LetterAvatar(auth()->user()->name, 'circle', 35);

                                     echo "<img class='avatar' src='".$avatar."'/>"

                                    @endphp

                                    <span>{{auth()->user()->name}}</span>
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top: 10px;">
                                <a href="{{route('main_user_settings')}}" class="dropdown-item"><i class="icofont-gear"></i> Settings</a>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="icofont-logout"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>


                @endauth

            </div>

        </div>

    </div>

</header>