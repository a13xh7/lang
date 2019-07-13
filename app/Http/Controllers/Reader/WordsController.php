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
use App\Models\Reader\Text;

use App\Models\Reader\Word;
use Illuminate\Http\Request;

class WordsController extends Controller
{

    public function showPage()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $words = $user->words()->paginate(10);


        return view('reader.reader_words')
            ->with('words', $words)
            ->with('totalWords', $user->words->count())
            ->with('totalKnownWords', $user->words()->where('state', \App\Config\Word::KNOWN)->count())
            ->with('totalNewWords', $user->words()->where('state', \App\Config\Word::NEW)->count())
            ;
    }

    public function showNewWords()
    {

    }

    public function showKnownWords()
    {

    }

    public function ajaxAddNewWord(Request $request)
    {

        // 1. Try to find word in database

        $word = Word::where('word', $request->get('word'))->where('lang_id', $request->get('lang_id'))->get();

        // if word doesn't exist add word to database
        if($word->isEmpty()){
            $word = new Word;
            $word->word = $request->get('word');
            $word->lang_id = $request->get('lang_id');
            $word->save();

            $word->users()->attach( auth()->user()->id, ['state' => $request->get('lang_id')]);

            // add translation

        } else {
            // if word exists. check if user has this word
            $user = $word->users()->where('user_id', auth()->user()->id)->get();

            // if user doesn't have this word. add word for this iser
            if($user->isEmpty()) {
                $word->users()->attach( auth()->user()->id, ['state' => $request->get('state')]);
            }
        }




//        DB::table('user_word')->insert(
//            ['user_id' => auth()->user()->id, 'word_id' => 0]
//        );

    }

    public function ajaxMarkWordAsKnown()
    {

    }
}