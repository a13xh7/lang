@extends('layouts.rt.rt_layout')


@section('rt_content')

    <h1>My texts</h1>

    @foreach($texts as $text)
        <p>{{$text->title}}</p>

    @endforeach

    <br>
    {{ $texts->links() }}



@endsection