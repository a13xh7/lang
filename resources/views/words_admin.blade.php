@extends('main_layout')


@section('content')

    <h1 class="uc">Manage words and translations</h1>

    <a href="{{route('delete_all_words')}}" type="button" class="btn btn-danger">Delete all</a>

    <br><br>

    {{--WORDS TABLE START--}}
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Word</th>
            <th scope="col">Translations</th>
        </tr>
        </thead>
        <tbody>

    @foreach($words as $word)
        <tr>
            <td>
                <button type="button" class="btn btn-danger btn-sm admin_word_delete_btn" data-word_id="{{$word->id}}">Delete</button>
                <span class="admin_word_size">{{$word->word}}</span>
            </td>

            <td>
                <span class="admin_word_size">{{$word->translation}}</span>
            </td>
        </tr>

    @endforeach

        </tbody>
    </table>
    {{--WORDS TABLE END--}}

    {{$words->links()}}


@endsection

