@extends('main_layout')


@section('content')

    <h2>Add new word</h2>
    <form action="{{route('add_new_word')}}" method="POST" >


        <div class="form-group">
            <label for="new_word">New Word</label>
            <input type="text" class="form-control" id="new_word" name="new_word" placeholder="word" required>
        </div>

        <div class="form-group">
            <label for="new_translation">Translation</label>
            <input type="text" class="form-control" id="new_translation" name="new_translation" placeholder="translation" required>
        </div>

        <div class="form-group">
            <label for="new_word_state">State</label>
            <select class="form-control" id="new_word_state" name="new_word_state">
                <option value="{{\App\Config\WordConfig::TO_STUDY}}">To study</option>
                <option value="{{\App\Config\WordConfig::KNOWN}}">Known</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100" >ADD</button>
    </form>

    <hr style="border: 1px solid #DCDCDC;">

    <h2>Delete all words: <a href="{{route('delete_all_words')}}" type="button" class="btn btn-danger">Delete all</a></h2>

    <hr style="border: 1px solid #DCDCDC;">

    {{--SEARCH FORM--}}
    <form class="form-inline" method="GET" action="{{route("words")}}">

        <p class="h2 pr-1">Find word</p>
        <input type="text" class="form-control mr-2" id="word_to_find" name="word_to_find" placeholder="word" value="{{ app('request')->get('word_to_find') }}">

        <button type="submit" class="btn btn-primary mr-2">Search</button>
        <a href="{{route("words")}}" class="btn btn-success">Reset</a>
    </form>
    {{--SEARCH FORM END--}}

    <hr style="border: 1px solid #DCDCDC;">


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
            <th scope="col" style="width: 15%">State</th>
            <th scope="col">Word</th>
            <th scope="col">Translation</th>
            <th scope="col" style="width: 10%">Delete word</th>
        </tr>
        </thead>
        <tbody>

    @foreach($words as $word)

        <tr>

            <td style="width: 15%">

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

            <td>
                <input class="admin_word_size" type="text" value="{{$word->translation}}">
                <button type="button" class="btn btn-success btn-sm admin_word_save_btn" data-word_id="{{$word->id}}">Save</button>
            </td>

            <td style="width: 10%">
                <button type="button" class="btn btn-danger btn-sm admin_word_delete_btn" data-word_id="{{$word->id}}">Delete</button>
            </td>

        </tr>

    @endforeach

        </tbody>
    </table>
    {{--WORDS TABLE END--}}

    {{$words->links()}}

@endsection

