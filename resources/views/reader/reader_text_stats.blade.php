@extends('layouts.reader.reader_layout')

@section('reader_content')


    <h1>Stats</h1>
    <div class="w3-border-bottom">
        <ul>
            <li>Text language <b>{{$text->lang->eng_title}}</b></li>
            <li>Pages - {{$text->total_pages}}</li>
            <li>Symbols - {{ $text->total_symbols}}</li>
            <li>Total words - {{ $text->total_words}}</li>
            <li>Unique words - {{ $text->unique_words}}</li>
        </ul>

        <p> </p>



    </div>

    <h1>Words</h1>

    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">


        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                <span class="h2">UNKNOWN / NEW: <span class="badge badge-warning"> 11</span> </span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary noradius" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                <span class="h2">KNOWN: <span class="badge badge-success">11</span> </span>
            </button>
        </li>

    </ul>

    <div class="row">

        {{--<div class="col-4">--}}
            {{--<ul class="list-group list-group-flush">--}}
                {{--<li class="list-group-item">Cras justo odio</li>--}}
                {{--<li class="list-group-item">Dapibus ac facilisis in</li>--}}
                {{--<li class="list-group-item">Morbi leo risus</li>--}}
                {{--<li class="list-group-item">Porta ac consectetur ac</li>--}}
                {{--<li class="list-group-item">Vestibulum at eros</li>--}}
            {{--</ul>--}}
        {{--</div>--}}



                @foreach($words as $arr)
            <div class="col-4">
                <ul class="list-group list-group-flush">
                    @foreach($arr as $word => $usage)

                        <li class="list-group-item">{{$word}} - {{$usage}}</li>


                    @endforeach

                </ul>
            </div>

                @endforeach










{{--@foreach($words as $word => $usage)--}}


    {{--<p>{{$word}} - {{$usage}}</p>--}}

{{--@endforeach--}}




@endsection