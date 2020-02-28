<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers;

use App\Config\WordConfig;
use App\Models\Text;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class TextStatsController extends Controller
{

    public function showTextStats(int $textId, Request $request)
    {
        $text = Text::findOrFail($textId);

        $words = $text->getWords();
        $knownWords = $text->getKnownWords();

        $myWords = Word::where('lang_id', $text->lang_id);

        /* SHOW words
        0 - all
        1 - unknown
        2 - known
         */

        // Filter Words - get only known or only new. By default we get all words.
        if($request->cookie('show_words') == WordConfig::TO_STUDY) {
            $filteredWords = [];

            foreach ($words as $word) {
                if(in_array($word[0], $knownWords) == false) {
                    $filteredWords[] = $word;
                }
            }
            $words = $filteredWords;

        } elseif ($request->cookie('show_words') == WordConfig::KNOWN) {

            $filteredWords = [];

            foreach ($words as $word) {
                if(in_array($word[0], $knownWords)) {
                    $filteredWords[] = $word;
                }
            }
            $words = $filteredWords;

        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 200;

        $wordsToShow = array_slice($words, $perPage * ($currentPage - 1), $perPage);

        $paginator = new LengthAwarePaginator($wordsToShow, count($words), $perPage, $currentPage);
        $paginator->withPath(''); // почему это вообще работает?



        return view('text_stats')
            ->with('text', $text)
            ->with('words', $wordsToShow)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords)
            ->with('paginator', $paginator)->withCookie('show_words', 1);
    }


}
