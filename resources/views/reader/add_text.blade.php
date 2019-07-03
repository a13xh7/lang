@extends('layouts.reader')




@section('content')

    <p>добавить валидацию </p>
    <h1>ADD TEXT</h1>

    <form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">

        @csrf
        <input type="text" name="title" value="tetx title"><br>
        <input type="file" name="textFile" id="textFile"><br>

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
        
        <button type="submit" name="submit">Upload</button>

    </form>

@endsection

