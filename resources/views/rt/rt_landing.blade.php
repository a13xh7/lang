@extends('layouts.main.main_layout')

@section('seo')

    <title>WexLang - Read Together</title>

@endsection

@section('main_content')


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
                    <p class="h1" style="text-align: center"><b class="uc">{{__('How it works')}}</b></p>
                </div>

                <div class="w-100"></div>

                <div class="col">

                    <ul style="font-size: 20px">
                        <li>{{__('You create public text by uploading text to the site')}}.</li>
                        <li>{{__('Uploaded text becomes available to everyone')}}.</li>
                        <li>{{__('Anyone can join the group to read the selected text')}}</li>
                    </ul>
                    <div class="text-center">
                        <img src="{{asset('img/rt/public_texts.jpg')}}" alt="" width="90%" class="mx-auto">
                    </div>

                    <p class="h2 text-center m-3">{{__('Questions are available on each text page')}}</p>

                    <ul style="font-size: 20px">
                        <li>{{__('You can create questions about the text and answer questions from other users')}}</li>
                        <li>{{__('The question is attached to the current page of the text, so everyone who read the text will see your question')}}</li>
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
