
@extends('layouts.main')


@section('main')

    <!-- MAIN CONTENT START-->
    <div class="row">

        <div class="container">
            <div class="row">

                @include('layouts.reader_sidebar')

                <main class="col">

                    @yield('reader_main')

                </main>
            </div>
        </div>


    </div>
    <!-- MAIN CONTENT END-->
@endsection

