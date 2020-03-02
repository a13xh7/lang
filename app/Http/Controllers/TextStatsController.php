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
        // SHOW words
        // 0 - all
        // 1 - unknown / to study
        // 2 - known

        $showWordsFilter = $request->get('show_words') != null ? $request->get('show_words') : 0;

        $text = Text::findOrFail($textId);

        $allWordsFromText = $text->getWords(); // array structure - [ [0=>'word', 1 => usage frequency, 2 => usage frequency (percent)] ]
        $myWordsInThisText = $text->getKnownAndToStudyWords(); // usual array - [0 => 'word', 1 => 'word' , etc...]
        $allMyWords = Word::where('lang_id', $text->lang_id)->get(); // all user worlds. the same language as the text

        // Filter Words. Do not filter if show_words == 0 (all)

        if($showWordsFilter == WordConfig::TO_STUDY) {
            $filteredWords = [];

            foreach ($allWordsFromText as $word) {
                if(in_array($word[0], $myWordsInThisText) == false ) {
                    $filteredWords[] = $word;
                }
            }

            $allWordsFromText = $filteredWords;

        } elseif ($showWordsFilter == WordConfig::KNOWN || $showWordsFilter == WordConfig::TO_STUDY ) {

            $filteredWords = [];

            foreach ($allWordsFromText as $word) {
                if(in_array($word[0], $myWordsInThisText)) {
                    $filteredWords[] = $word;
                }
            }

            $allWordsFromText = $filteredWords;
        }

        // This is pagination

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 200;
        $wordsFromTextPaginated= array_slice($allWordsFromText, $perPage * ($currentPage - 1), $perPage);
        $paginator = new LengthAwarePaginator($wordsFromTextPaginated, count($allWordsFromText), $perPage, $currentPage);
        $paginator->withPath(''); // почему это вообще работает?

        return view('text_stats')
            ->with('text', $text)
            ->with('words', $wordsFromTextPaginated)
            ->with('myWordsInThisText', $myWordsInThisText)
            ->with('allMyWords', $allMyWords)
            ->with('paginator', $paginator);
    }


}
