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
}