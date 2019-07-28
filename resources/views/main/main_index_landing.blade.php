@extends('layouts.main.main_layout')

@section('main_content')


    <div class="container-fluid">

        <div class="container">

            <div class="row" style="min-height: 300px">
                <div class="col">
                    <p class="h1 mt-5" style="text-align: center">
                        Изучайте иностранные языки, читая то, что вам нравится. <br>
                        В оригинале. <br>
                        Не отвлекаясь на словарь.
                    </p>

                </div>

                <div class="w-100"></div>

                <div class="col mt-3 mb-3">
                    <a href="{{ route('reader_landing') }}" class="btn btn-primary noradius w-100 p-2"><i class="icofont-user-alt-3"></i> <b>УЗНАТЬ БОЛЬШЕ...</b> </a>
                </div>

                <div class="w-100"></div>

                <div class="col" style="text-align: center">
                    <p class="h2"><b>17 языков </b> и любые направления перевода в beta версии.</p>

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
                    <p class="h2">Более <b>100 языков</b>  будет доступно после бета-тестирования!</p>
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
                        Читайте книги на иностранном языке вместе.
                        <br><br>
                        Помогайте друг другу с пониманием и изучением иностранного языка.
                    </p>

                </div>

                <div class="w-100"></div>


                <div class="col mt-3 mb-3">
                    <a href="{{ route('rt_landing') }}" class="btn btn-primary noradius w-100 p-2"><i class="icofont-user-alt-3"></i> <b>УЗНАТЬ БОЛЬШЕ...</b> </a>
                </div>

            </div>

        </div>
    </div>

    <hr>

    <div class="container-fluid">

        <div class="container">

            <div class="row">

                <div class="col">

                    <p class="h1 text-center mt-3"><b>СООБЩЕСТВО</b></p>

                    <p style="font-size: 18px" class="text-center">
                        Не можете понять смысл предложения, несмотря на то что знаете или перевели все слова?
                        <br>
                        Тогда добро пожаловать в <a href="{{route('qa_index')}}"><b>Вопросы и Ответы</b></a>
                        <br>
                        Задавайте вопросы и помогайте другим пользователям в изучении иностранных языков.
                    </p>

                    <div class="text-center">
                        <img src="{{asset('img/rl/qa.jpg')}}" alt="" width="100%" class="mx-auto">
                    </div>

                </div>

            </div>

        </div>

    </div>





@endsection
