@extends('main_layout')


@section('content')

    <h1 class="uc">Manage words and translations</h1>

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

                (<img src="{{'/img/flags/'. \App\Config\Lang::get($word->lang_id)['code'] . '.svg'}}" class="admin_flag" alt="">
                <span class="text-muted admin_lang_name">{{\App\Config\Lang::get($word->lang_id)['title']}}</span>)

                <span class="admin_word_size">{{$word->word}}</span>
            </td>

            <td>
                <ul>

                    @foreach($word->translations()->get() as $translation)

                        <li>
                            <button type="button" class="btn btn-danger btn-sm admin_translation_delete_btn" data-translation_id="{{$word->id}}">Delete</button>
                            (<img src="{{'/img/flags/'. \App\Config\Lang::get($translation->lang_id)['code'] . '.svg'}}" class="admin_flag" alt="">
                            <span class="text-muted admin_lang_name">{{\App\Config\Lang::get($translation->lang_id)['title']}}</span>)

                            <span class="admin_word_size">{{$translation->translation}}</span>
                        </li>


                    @endforeach
                </ul>

            </td>
        </tr>

    @endforeach

        </tbody>
    </table>
    {{--WORDS TABLE END--}}

    {{$words->links()}}


@endsection

