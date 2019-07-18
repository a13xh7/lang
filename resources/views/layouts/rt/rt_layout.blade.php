@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="container">

            <div class="row">

                @include('layouts.rt.rt_left_sidebar')

                <div class="col reader_main_content">

                   @yield('rt_content')

                </div>
            </div>
        </div>

    </main>

@endsection