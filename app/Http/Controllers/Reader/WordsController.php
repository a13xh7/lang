<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;

use App\Models\Reader\Word;
use Illuminate\Http\Request;

class WordsController extends Controller
{

    public function showPage()
    {
        $words = Word::where('user_id', auth()->user()->id)->paginate(1);
        $totalWords = Word::where('user_id', auth()->user()->id)->count();

        return view('reader.words')->with('words', $words)->with('totalWords', $totalWords);
    }

    public function showNewWords()
    {
        $words = Word::where('user_id', auth()->user()->id)->paginate(1);
        $totalWords = Word::where('user_id', auth()->user()->id)->count();

        return view('reader.words')->with('words', $words)->with('totalWords', $totalWords);
    }

    public function showKnownWords()
    {
        $words = Word::where('user_id', auth()->user()->id)->paginate(1);
        $totalWords = Word::where('user_id', auth()->user()->id)->count();

        return view('reader.words')->with('words', $words)->with('totalWords', $totalWords);
    }
}