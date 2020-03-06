@extends('main_layout')

@section('content')

    <h1>Text statistics</h1>

    <div class="w3-border-bottom">
        <ul>
            <li>Unique words: <b>{{ $text->unique_words}}</b></li>
            <li>Total words: <b>{{ $text->total_words}}</b></li>
            <li>Symbols: <b>{{ $text->total_symbols}}</b></li>
            <li>Pages: <b>{{$text->total_pages}}</b></li>
        </ul>
    </div>

    <h1>Text words <span class="h6 text-muted">Click on buttons to filter words</span></h1>

    {{--FILTERS START--}}
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">

        @php
            $isAllDisabled = app('request')->input('show_words') == \App\Config\WordConfig::NEW ? "disabled" : "";
            $isUnknownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::TO_STUDY ? "disabled" : "";
            $isKnownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::KNOWN ? "disabled" : "";
        @endphp

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::NEW}}" type="button" class="btn btn-primary noradius {{$isAllDisabled}}">
                <span class="h3">ALL: <span class="badge badge-dark"> {{ $text->unique_words}}</span> </span>
            </a>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::TO_STUDY}}" type="button" class="btn btn-primary noradius {{$isUnknownDisabled}}">
                <span class="h3">NEW / UNKNOWN: <span class="badge badge-warning"> {{ count($text->getUnknownWords()) }}</span> </span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::KNOWN}}" type="button" class="btn btn-primary noradius {{$isKnownDisabled}}">
                <span class="h3">KNOWN / TO STUDY: <span class="badge badge-success">{{ count($text->getKnownAndToStudyWords())}}</span> </span>
            </a>
        </li>

    </ul>
    {{--FILTERS END--}}

    {{--WORDS TABLE START--}}
    <div class="row">

        <table class="table" id="all_text_words">
            <thead class="thead-light">
            <tr>
                <th scope="col">State</th>
                <th scope="col">Word</th>
                <th scope="col">Translation</th>
                <th scope="col">Usage frequency</th>
            </tr>
            </thead>
            <tbody>

            @foreach($words as $word)

                <tr>
                    {{--STATE START--}}
                    <td>

                        @if(in_array($word[0], $myWordsInThisText) == false)
                            <button type="button" class="btn btn-warning btn-sm word_btn"
                                    data-word="{{$word[0]}}"
                                    data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>

                            <button type="button" class="btn btn-success btn-sm word_btn"
                                    data-word="{{$word[0]}}"
                                    data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                        @else

                            @if($allMyWords->where('word', $word[0])->first()->state == \App\Config\WordConfig::TO_STUDY)
                                <span class="badge badge-warning h4">To study</span>
                            @else
                                <span class="badge badge-success h4">Known</span>
                            @endif

                        @endif

                    </td>
                    {{--STATE END--}}

                    <td>{{$word[0]}}</td>

                    {{--TRANSLATION START--}}

                    <td>
                        @if(in_array($word[0], $myWordsInThisText))
                            {{$allMyWords->where('word', $word[0])->first()->translation}}
                        @else
                            -
                        @endif
                    </td>

                    {{--TRANSLATION END--}}


                    <td>{{$word[1]}} <span class="small text-muted">{{$word[2]}}%</span> </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>
    {{--WORDS TABLE END--}}

    {{$paginator->links()}}

@endsection
