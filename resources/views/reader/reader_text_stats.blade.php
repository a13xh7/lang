@extends('layouts.reader.reader_layout')

@section('reader_content')


    <h1>Stats</h1>
    <div class="w3-border-bottom">
        <ul>
            <li>Text language <b>{{ \App\Config\Lang::get($text->lang_id)['eng_title']}}</b></li>
            <li>Pages - <b>{{$text->total_pages}}</b></li>
            <li>Symbols - <b>{{ $text->total_symbols}}</b></li>
            <li>Total words - <b>{{ $text->total_words}}</b></li>
            <li>Unique words - <b>{{ $text->unique_words}}</b></li>
        </ul>

        <p> </p>



    </div>

    <h1>Words</h1> <span class="text-muted">Click on buttons to filter words</span>

    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="show_all_words">
                <span class="h2">ALL: <span class="badge badge-dark"> {{ $text->unique_words}}</span> </span>
            </button>
        </li>


        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="show_unknown_words">
                <span class="h2">UNKNOWN: <span class="badge badge-warning"> {{ count($text->getUnknownWords()) }}</span> </span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary noradius" id="show_known_words">
                <span class="h2">KNOWN: <span class="badge badge-success">{{ count($knownWords) }}</span> </span>
            </button>
        </li>

    </ul>

    {{--<form action="{{route('reader_add_new_word')}}" method="POST">--}}
{{--@csrf--}}
        {{--word <input type="text" name="word">--}}
        {{--lang id <input type="text" name="lang_id" value="1">--}}
        {{--state <input type="text" name="state" value="1">--}}
        {{--<button type="submit">Send</button>--}}

    {{--</form>--}}


    <div class="row">

        <table class="table" id="all_text_words">
            <thead class="thead-light">
            <tr>
                <th>State</th>
                <th scope="col">Word</th>
                <th scope="col">Usage frequency</th>
                <th scope="col">Percent</th>
            </tr>
            </thead>
            <tbody>

            @foreach($words as $word)

                <tr>
                    <td>

                        @if(!in_array($word[0], $knownWords))
                            <button type="button" class="btn btn-warning btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text->lang_id}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                            <button type="button" class="btn btn-success btn-sm word_btn" data-word="{{$word[0]}}" data-lang_id="{{$text->lang_id}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>

                        @else


                            @if($myWords->where('word', $word[0])->first()->pivot->state == \App\Config\WordConfig::TO_STUDY)
                                <span class="badge badge-warning h4">To study</span>
                            @else
                                <span class="badge badge-success h4">Known</span>
                            @endif

                        @endif


                    </td>
                    <td>{{$word[0]}}</td>
                    <td>{{$word[1]}} </td>
                    <td>{{$word[2]}}</td>
                </tr>

            @endforeach



            </tbody>
        </table>

</div>

    {{$paginator->links()}}




@endsection