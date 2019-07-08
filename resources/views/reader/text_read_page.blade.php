@extends('layouts.reader')

@section('reader_main')

    <div style="white-space: pre-wrap;"> {!! $page->content !!}</div>



        <div class="w3-border">
            {{$pages->links()}}
        </div>


    @endsection