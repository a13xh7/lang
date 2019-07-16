@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row qa_main">

        <div class="container" > {{--style="max-width: 1440px !important;"--}}

            <div class="row">

                @include('layouts.qa.qa_left_sidebar')

                <div class="col qa_main_content">

                   @yield('qa_content')

                </div>

                {{--@include('layouts.qa.qa_right_sidebar')--}}

            </div>
        </div>

    </main>

@endsection