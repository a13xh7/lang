@extends('layouts.reader')




@section('content')

    <h1>ADD TEXT</h1>

    <form action="{{route('reader_add_text')}}" method="POST" enctype="multipart/form-data">

        @csrf
        <input type="file" name="textFile" id="textFile">
        <button type="submit" name="submit">Upload</button>

    </form>

@endsection

