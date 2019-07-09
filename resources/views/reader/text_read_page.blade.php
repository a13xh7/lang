@extends('layouts.reader.reader_layout')

@section('reader_content')

    <div style="white-space: pre-wrap;">
        {!! $page->content !!}
    </div>




    {{$pages->links()}}



    @endsection