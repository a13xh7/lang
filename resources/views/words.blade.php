@extends('main_layout')


@section('content')

    <h1 class="uc">My words</h1>

    {{--FILTERS START--}}
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">

        @php
            $isAllDisabled = app('request')->input('show_words') == \App\Config\WordConfig::NEW ? "disabled" : "";
            $isUnknownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::TO_STUDY ? "disabled" : "";
            $isKnownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::KNOWN ? "disabled" : "";
        @endphp

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('words')}}?show_words={{\App\Config\WordConfig::NEW}}" type="button" class="btn btn-primary noradius {{$isAllDisabled}}">
                <span class="h2">ALL: <span class="badge badge-light">{{ $totalWords }}</span> </span>
            </a>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('words')}}?show_words={{\App\Config\WordConfig::TO_STUDY}}" type="button" class="btn btn-primary {{$isUnknownDisabled}}">
                <span class="h2">TO STUDY: <span class="badge badge-warning">{{ $totalNewWords }} </span> </span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('words')}}?show_words={{\App\Config\WordConfig::KNOWN}}" type="button" class="btn btn-primary noradius {{$isKnownDisabled}}">
                <span class="h2">KNOWN: <span class="badge badge-success">{{ $totalKnownWords }}</span> </span>
            </a>
        </li>

    </ul>
    {{--FILTERS END--}}

    {{--WORDS TABLE START--}}
    <table class="table" id="all_text_words">
        <thead class="thead-light">
        <tr>
            <th>State</th>
            <th scope="col">Word</th>
            <th scope="col">Translation</th>
        </tr>
        </thead>
        <tbody>

    @foreach($words as $word)

        <tr>
            <td>

                @if($word->state == \App\Config\WordConfig::NEW )
                    <button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="{{$word->id}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                    <button type="button" class="btn btn-success btn-sm word_btn" data-word_id="{{$word->id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                @endif

                @if($word->state == \App\Config\WordConfig::TO_STUDY )
                    <span class="badge badge-warning h4">To study</span>
                    <button type="button" class="btn btn-success btn-sm word_btn" data-word_id="{{$word->id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                @endif

                @if($word->state == \App\Config\WordConfig::KNOWN )
                    <button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="{{$word->id}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                    <span class="badge badge-success h4">Known</span>
                @endif

            </td>
            <td>{{$word->word}}</td>
            <td> {{$word->translation}} </td>
        </tr>

    @endforeach

        </tbody>
    </table>
    {{--WORDS TABLE END--}}

    {{$words->links()}}

@endsection

