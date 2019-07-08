<!-- HEADER START-->
<header class="row border-bottom sticky-top bg-white shadow-sm header">

    <div class="container align-self-center">

        <div class="row">

            <div class="col-2">
                <a href="" class="logo">
                    LANG LOGO
                </a>
            </div>

            <nav class="col justify-content-center header-menu">

                @auth
                    <a href="{{ route('main_dashboard') }}" class="w3-bar-item w3-button">HOME</a>
                @endauth

                @guest
                    <a href="{{ route('index_landing') }}" class="w3-bar-item w3-button">HOME</a>
                @endguest


                @auth
                    <a href="{{ route('reader_dashboard') }}" class="w3-bar-item w3-button">READER</a>
                @endauth

                @guest
                    <a href="{{ route('reader_landing') }}" class="w3-bar-item w3-button">READER</a>
                @endguest




                <a href="">Text stats</a>
                <a href="">Groups</a>
                <a href="{{ route('qa_index') }}">Q & A</a>
            </nav>

            <div class="col-3 nopadding nav-left justify-content-end">

                @guest
                <a href="{{ route('login') }}" class="btn btn-primary">LOGIN</a>
                <a href="{{ route('register') }}" class="btn btn-primary">REGISTER</a>
                @endguest

                    @auth

                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>


                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>


                    @endauth
            </div>

        </div>

    </div>

</header>
<!-- HEADER END-->


