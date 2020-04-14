@extends('main_layout')

@section('content')

    <h1>{{__('Text statistics')}}</h1>

    <div class="w3-border-bottom">
        <ul>
            <li>{{__('Total words')}}: <b>{{ $text->total_words}}</b></li>
            <li>{{__('Unique words ')}}: <b>{{ $text->unique_words}}</b></li>
            <li>{{__('Unknown Words')}}: <span class="badge badge-info">{{ count($text->getUnknownWords()) }}</span></li>
            <li>{{__('To study words')}}: <span class="badge badge-warning">{{ count($text->getToStudyWords()) }}</span></li>
            <li>{{__('Known words')}}: <span class="badge badge-success">{{ count($text->getKnownWords()) }}</span></li>
            <li>{{__('Symbols')}}: <b>{{ $text->total_symbols}}</b></li>
            <li>{{__('Pages')}}: <b>{{$text->total_pages}}</b></li>
            <br>
            <li> <a href="{{route("text_stats_export_csv", $text->id)}}" type="submit" class="btn btn-info" >{{__('EXPORT ALL AS')}} <b>CSV</b></a></li>
        </ul>

    </div>



    <h1>{{__('Text words')}}</h1>

    {{--FILTERS START--}}
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">

        @php
            $isAllDisabled = app('request')->input('show_words') == \App\Config\WordConfig::NEW ? "disabled" : "";
            $isUnknownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::TO_STUDY ? "disabled" : "";
            $isKnownDisabled = app('request')->input('show_words') == \App\Config\WordConfig::KNOWN ? "disabled" : "";
        @endphp

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::NEW}}" type="button" class="btn btn-primary noradius {{$isAllDisabled}}">
                <span class="h3 uc">{{__('All')}}: <span class="badge badge-dark"> {{ $text->unique_words}}</span> </span>
            </a>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::TO_STUDY}}" type="button" class="btn btn-primary noradius {{$isUnknownDisabled}}">
                <span class="h3">{{__('UNKNOWN')}}: <span class="badge badge-dark"> {{ count($text->getUnknownWords()) }}</span> </span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('text_stats', $text->id)}}?show_words={{\App\Config\WordConfig::KNOWN}}" type="button" class="btn btn-primary noradius {{$isKnownDisabled}}">
                <span class="h3">{{__('KNOWN / TO STUDY')}}: <span class="badge badge-success">{{ count($text->getMyWordsInThisText())}}</span> </span>
            </a>
        </li>

    </ul>
    {{--FILTERS END--}}

    {{--WORDS TABLE START--}}
    <div class="row">

        <table class="table" id="all_text_words">
            <thead class="thead-light">
            <tr>
                <th scope="col">{{__('State')}}</th>
                <th scope="col">{{__('Word')}}</th>
                <th scope="col">{{__('Translation')}}</th>
                <th scope="col">{{__('Usage frequency')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($words as $word)

                <tr>
                    {{--STATE START--}}
                    <td>

                        @if($word['id'] == null)
                            <button type="button" class="btn btn-warning btn-sm word_btn"
                                    data-word="{{$word['word']}}"
                                    data-state="{{\App\Config\WordConfig::TO_STUDY}}">{{__('To study')}}</button>

                            <button type="button" class="btn btn-success btn-sm word_btn"
                                    data-word="{{$word['word']}}"
                                    data-state="{{\App\Config\WordConfig::KNOWN}}">{{__('Known')}}</button>
                        @else

                            @if($word['state'] == \App\Config\WordConfig::TO_STUDY)
                                <span class="badge badge-warning h4">{{__('To study')}}</span>
                            @else
                                <span class="badge badge-success h4">{{__('Known')}}</span>
                            @endif

                        @endif

                    </td>
                    {{--STATE END--}}

                    <td>{{$word['word']}}</td>

                    {{--TRANSLATION START--}}

                    <td>
                        @if($word['translation'] != null)
                            {{ $word['translation'] }}
                        @else
                            -
                        @endif
                    </td>

                    {{--TRANSLATION END--}}


                    <td>{{$word['usage']}} <span class="small text-muted">{{$word['usage_percent']}}%</span> </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>
    {{--WORDS TABLE END--}}

    {{$paginator->links()}}

@endsection
