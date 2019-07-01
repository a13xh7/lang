<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
</head>
<body>


<header>

    <nav class="w3-bar w3-dark-grey">

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





        <a href="#" class="w3-bar-item w3-button">Q&A</a>

        @guest
            <a href="{{ route('login') }}" class="w3-bar-item w3-button">LOGIN</a>
            <a href="{{ route('register') }}" class="w3-bar-item w3-button">REGISTER</a>
        @endguest

        @auth
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endauth




        {{--<a href="{{ route('register') }}" class="w3-bar-item w3-button">USER SETTINGS</a>--}}
    </nav>

</header>