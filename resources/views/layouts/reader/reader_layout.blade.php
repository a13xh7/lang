@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="container">

            <div class="row">

                @include('layouts.reader.reader_left_sidebar')

                <div class="col reader_main_content">

                   @yield('reader_content')

                </div>
            </div>
        </div>

    </main>

@endsection