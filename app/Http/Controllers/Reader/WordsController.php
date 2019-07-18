<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Main\User;

use App\Models\Reader\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordsController extends Controller
{

    public function showPage(Request $request)
    {
        $perPage = 10;
        $user = User::where('id', auth()->user()->id)->first();
        $words = $user->words()->paginate($perPage);

        /* SHOW words
            1 - unknown
            2 - known
         */

        // Filter Words - get only known or only new. By default we get all words.
        if($request->cookie('show_words') == 1) {
            $words = $user->words()->where('state', \App\Config\WordConfig::TO_STUDY)->paginate($perPage);
        } elseif ($request->cookie('show_words') == 2) {
            $words = $user->words()->where('state', \App\Config\WordConfig::KNOWN)->paginate($perPage);
        }



        return view('reader.reader_words')
            ->with('words', $words)
            ->with('totalWords', $user->words->count())
            ->with('totalKnownWords', $user->words()->where('state', \App\Config\WordConfig::KNOWN)->count())
            ->with('totalNewWords', $user->words()->where('state', \App\Config\WordConfig::TO_STUDY)->count())
            ;
    }


    public function ajaxAddNewWord(Request $request)
    {

        /**
         *  Логика - новое слово. в базе его нет
         *
         * 1. Проверить существует ли слово в таблице words
         * 2. Если слова в базе нет - достать перевод, сохранить слово, сохранить перевод, сохранить связть в таблице user_word
         *
         * Логика - слово уже есть в базе
         *
         *  1. проверить есть ли это слово у пользователя
         *  2. Если слова нет - добавить запись в таблицу
         *
        */


        // 1. Try to find word in database

        $user = User::where('id', auth()->user()->id)->first();


        // if word doesn't exist add word to database
        $word = Word::where('word', $request->get('word'))->where('lang_id', $request->get('lang_id'))->first();
        if($word == null){
            $word = new Word;
            $word->word = $request->get('word');
            $word->lang_id = $request->get('lang_id');
            $word->save();

            $word->users()->attach( auth()->user()->id, ['state' => $request->get('state')]);

            // add translation

        } else {
            // if word exists. check if user has this word

            $userWord = $user->words()->where('word_id', $word->id)->first();


            // if user doesn't have this word. add word for this user
            if($userWord == null) {
                $user->words()->attach( $word->id, ['state' => $request->get('state')]);
            }
        }


    }

    public function ajaxUpdateWordState(Request $request)
    {
        $word = Word::find($request->get('word_id'));
        $word->users()->updateExistingPivot(auth()->user()->id, ['state' => $request->get('state')]);
        $word->save();
    }
}