@extends('layouts.main')

@section('main')


    <form action="{{route('qa_add_question')}}" method="post">
@csrf
        Lang from <select name="lang_from">

            @foreach($languages as $lang)

                <option value="{{$lang->id}}">{{$lang->eng_title}}</option>

            @endforeach

        </select><br>

        Lang to <select name="lang_to">
            @foreach($languages as $lang)

                <option value="{{$lang->id}}">{{$lang->eng_title}}</option>

            @endforeach
        </select><br>

        <p>title <input type="text" name="title"></p>
        <p>content <input type="text" name="content"></p>

        <input type="hidden" name="group_id" value="0">

        <button type="submit" name="submit">Upload</button>
    </form>


@endsection