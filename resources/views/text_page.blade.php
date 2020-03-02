@extends('text_page_layout')

@section('content')

<div class="row justify-content-md-center mt-3">
    <div class="col-md-auto">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><b class="uc">{{__('Text')}}</b></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><b class="uc">{{__('Words')}}</b></a>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="pills-tabContent">

    {{-- PAGE CONTENT START--}}
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

        <div class="page_text_wrapper">{!! $pageContent !!}</div>

        <div class="mt-3">
            {{$pages->links()}}
        </div>

    </div>
    {{-- PAGE CONTENT END--}}


    {{-- PAGE WORDS START--}}
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

        <h1>{{__('Unique words on this page')}} ({{count($words)}})</h1>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col" style="width:20%">State</th>
                <th scope="col" style="width:25%">Word</th>
                <th scope="col" style="width:30%">Translation</th>
                <th scope="col" style="width:25%">Usage frequency</th>
            </tr>
            </thead>
            <tbody>

            @foreach($words as $word)

                <tr>
                    <td>

                        @if(!in_array($word[0], $knownWords))
                            <button type="button" class="btn btn-warning btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text_lang_id}}" data-translate_to_lang_id="{{$translate_to_lang_id}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                            <button type="button" class="btn btn-success btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text_lang_id}}" data-translate_to_lang_id="{{$translate_to_lang_id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>

                        @else
                            @if($myWords->where('word', $word[0])->first()->state == \App\Config\WordConfig::TO_STUDY)
                                <span class="badge badge-warning h4">To study</span>
                            @else
                                <span class="badge badge-success h4">Known</span>
                            @endif
                        @endif

                    </td>

                    <td>{{$word[0]}}</td>

                    <td>

                        @if($myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first() != null)


                            @if($myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first()->translation != null)
                                {{$myWords->where('word', $word[0])->where('lang_id', $text_lang_id)->first()->translation->translation}}
                            @endif


                        @endif

                    </td>

                    <td>{{$word[1]}} <span class="small text-muted">({{$word[2]}}%)</span> </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>
    {{-- PAGE WORDS END--}}

</div>

@endsection
