<?php

namespace App\Http\Controllers\RT;

use App\Config\WordConfig;
use App\Http\Controllers\Controller;

use App\Models\Main\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RTTextStatsController extends Controller
{
    public function showTextStats(int $textId, Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $text = $user->texts()->find($textId);

        $words = $text->getWords();
        $knownWords = $text->getKnownWords();
        $myWords = $user->words()->where('user_id', auth()->user()->id)->get();

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
        $paginator->withPath(''); // почему эта хуйня вообще работает?



        return view('rt.rt_text_stats')
            ->with('text', $text)
            ->with('words', $wordsToShow)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords)
            ->with('paginator', $paginator)->withCookie('show_words', 1);
    }


}
