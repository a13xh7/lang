@extends('layouts.reader')

@section('content')

    <h1>TEXT PAGE</h1>


    <div >


    {!! $page->content !!}


        </div>



        <div class="w3-border">
            {{$pages->links()}}
        </div>


    @endsection