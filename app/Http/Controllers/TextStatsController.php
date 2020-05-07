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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class TextStatsController extends Controller
{

    public function showTextStats(int $textId, Request $request)
    {
        // SHOW words
        // 0 - all
        // 1 - new / unknown
        // 2 - known / to study

        $wordsToShow = [];
        $wordsFilter = $request->get('show_words') != null ? $request->get('show_words') : 0;
        $text = Text::findOrFail($textId);

        // Get all words from text
        $allWordsFromText = $text->getWords(); // array structure - [ [0=>'word', 1 => usage frequency, 2 => usage frequency (percent)] ]

        // Add words from text to $wordsToShow array

        foreach ($allWordsFromText as $word) {
            $wordsToShow[$word[0]] = [
                'id' => null,
                'state' => null,
                'word' => $word[0],
                'translation' => null,
                'usage' => $word[1],
                'usage_percent' => $word[2]
            ];
        }

        // Get my words from this text and set id, translation and state

        $myWordsInThisText = $text->getMyWordsInThisText();

        foreach ($myWordsInThisText as $word) {
            if(!empty($wordsToShow[$word->word])) {
                $wordsToShow[$word->word]['id'] = $word->id;
                $wordsToShow[$word->word]['state'] = $word->state;
                $wordsToShow[$word->word]['translation'] = $word->translation;
            }
        }

        // Filter Words. Do not filter if show_words == 0 (all)

        // 1 - new / unknown words
        if($wordsFilter == 1) {
            $filteredWords = [];
            foreach ($wordsToShow as $word) {
                if($word['id'] == null) {
                    $filteredWords[$word['word']] = $word;
                }
            }
            $wordsToShow = $filteredWords;
        }

        // 2 - to study / known words
        if($wordsFilter == 2) {
            $filteredWords = [];
            foreach ($wordsToShow as $word) {
                if($word['id'] != null) {
                    $filteredWords[$word['word']] = $word;
                }
            }
            $wordsToShow = $filteredWords;
        }

        // This is pagination

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 50;
        $wordsFromTextPaginated = array_slice($wordsToShow, $perPage * ($currentPage - 1), $perPage);
        $paginator = new LengthAwarePaginator($wordsFromTextPaginated, count($wordsToShow), $perPage, $currentPage);
        $paginator->withPath(''); // почему это вообще работает?

        return view('text_stats')
            ->with('text', $text)
            ->with('words', $wordsFromTextPaginated)
            ->with('wordsFilter', $wordsFilter)
            ->with('paginator', $paginator);
    }


    public function exportToCsv(int $textId, Request $request)
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=TextStats.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $text = Text::findOrFail($textId);
        $words = $text->getWords(); // array structure - [ [0=>'word', 1 => usage frequency, 2 => usage frequency (percent)] ]

        $callback = function() use ($words)
        {
            $columnNames = ['Word', 'Usage frequency', 'Usage frequency (%)'];

            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames, ";");
            foreach ($words as $word) {
                $usage = $word[1];
                $usagePercent = $word[2];
                fputcsv($file, [$word[0] , $usage, $usagePercent], ";");
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
