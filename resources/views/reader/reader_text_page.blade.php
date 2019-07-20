@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row">

        <div class="col-2 bg-light">
            controls settings and info
        </div>

        <div class="col">
            <div style="white-space: pre-wrap;">
                {!! $page->content !!}
            </div>
        </div>

        <div class="col-3 bg-light">
            translation and wor settings
        </div>


    </main>






    {{$pages->links()}}



    @endsection