@extends('layouts.reader')

@section('content')

    <h1>TEXT PAGE</h1>


    <div style="white-space: pre-wrap;"> {!! $page->content !!}</div>



        <div class="w3-border">
            {{$pages->links()}}
        </div>


    @endsection