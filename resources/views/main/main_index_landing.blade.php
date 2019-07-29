@extends('layouts.main.main_layout')

@section('main_content')



    <div class="container-fluid">

        <div class="container">

            <div class="row" style="min-height: 300px">
                <div class="col">
                    <p class="h1 mt-5" style="text-align: center">
                        {{__('Learn a language by reading whatever you like')}}. <br>
                        {{__('Read books in original language')}}. <br>
                        {{__('Without being distracted by a dictionary')}}.
                    </p>

                </div>

                <div class="w-100"></div>

                <div class="col mt-3 mb-3">
                    <a href="{{ route('register') }}" class="btn btn-primary noradius w-100 p-2"><i class="icofont-user-alt-3"></i> <b class="uc">{{__('Register')}}</b> </a>
                </div>

                <div class="w-100"></div>

                <div class="col" style="text-align: center">
                    <p class="h2"><b>{{__('17 languages')}}</b> {{__('and any translation directions are available in the beta version')}}.</p>

                    <div class="langs" >
                        <img src="img/flags/{{ \App\Config\Lang::get(1)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(2)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(3)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(4)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(5)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(6)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(7)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(8)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(9)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(10)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(11)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(12)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(13)['code'] }}.svg" width="80px" height="40px" alt="">
                    </div>
                    <br>
                    <div>
                        <img src="img/flags/{{ \App\Config\Lang::get(14)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(15)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(16)['code'] }}.svg" width="80px" height="40px" alt="">
                        <img src="img/flags/{{ \App\Config\Lang::get(17)['code'] }}.svg" width="80px" height="40px" alt="">
                    </div>

                    <br>
                    <p class="h2">{{__('More than')}} <b>{{__('100 languages')}}</b>  {{__('will be available after beta-testing')}}!</p>
                </div>

            </div>

        </div>
    </div>

    <hr>

    <div class="container-fluid">

        <div class="container">

            <div class="row" style="min-height: 300px">
                <div class="col">
                    <p class="h1 mt-5" style="text-align: center">
                        {{__('Read foreign language books together')}}.
                        <br><br>
                        {{__('Help each other with understanding and learning a foreign language')}}.
                    </p>

                </div>

                <div class="w-100"></div>

                <div class="col mt-3 mb-3">
                    <a href="{{ route('register') }}" class="btn btn-primary noradius w-100 p-2"><i class="icofont-user-alt-3"></i> <b class="uc"> {{__('Register')}}</b> </a>
                </div>

                <div class="w-100"></div>

            </div>

        </div>
    </div>

    <hr>

    <div class="container-fluid">

        <div class="container">

            <div class="row">

                <div class="col">

                    <p class="h1 text-center mt-3"><b class="uc">{{__('Community')}}</b></p>

                    <p style="font-size: 18px" class="text-center">
                        {{__('Сan not understand the meaning of the sentence, despite the fact that you know or translated all the words')}}?
                        <br>
                        {{__('Then welcome to')}} <a href="{{route('qa_index')}}"><b> {{__('Questions & Answers')}}</b></a>
                        <br>
                        {{__('Ask questions and help other users to learn foreign languages')}}.
                    </p>

                    <div class="text-center">
                        <img src="{{asset('img/rl/qa.jpg')}}" alt="" width="100%" class="mx-auto">
                    </div>

                </div>

            </div>

        </div>

    </div>





@endsection
