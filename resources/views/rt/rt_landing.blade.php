@extends('layouts.main.main_layout')

@section('main_content')


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
                    <a href="{{ route('register') }}" class="btn btn-primary noradius w-100 p-2"><i class="icofont-user-alt-3"></i> <b>РЕГИСТРАЦИЯ</b> </a>
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
                    <p class="h1" style="text-align: center"><b>КАК ЭТО РАБОТАЕТ</b></p>
                </div>

                <div class="w-100"></div>

                <div class="col">

                    <ul style="font-size: 20px">
                        <li>Вы создаете публичный текст загружая текстовый файл или книгу в формате <b>txt, fb2, pdf</b>.
                            Или просто загружаете текст через текстовое поле в форме.</li>
                        <li>
                            Загруженный текст становится доступен всем.
                        </li>
                        <li>Все желающие могут добавить текст себе / вступить в группу для чтения выбранного текста</li>
                    </ul>
                    <div class="text-center">
                        <img src="{{asset('img/rt/public_texts.jpg')}}" alt="" width="90%" class="mx-auto">
                    </div>

                    <p class="h2 text-center m-3">На каждой странице текста доступны вопросы</p>

                    <ul style="font-size: 20px">
                        <li>Вы можете создавать вопросы по тексту и отвечать на вопросу других пользователей</li>
                        <li>Вопрос привязывается в текущей странице текста, поэтому все, кто будет читать текст, увидят ваш вопрос </li>
                    </ul>

                    <div class="text-center">
                        <img src="{{asset('img/rt/text_questions.jpg')}}" alt="" width="90%"  class="mx-auto">
                    </div>

                </div>

            </div>

        </div>


    </div>

    <br><br><br>




@endsection
