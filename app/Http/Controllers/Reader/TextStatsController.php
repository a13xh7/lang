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
use App\Models\Reader\TextStats;
use App\Services\TextHandler;
use Illuminate\Http\Request;

class TextStatsController extends Controller
{

    public function showTextStats(int $textId)
    {

        $user = User::where('id', auth()->user()->id)->first();

        $text = $user->texts()->find($textId);

        $fullText = '';


        foreach ($text->pages as $page)
        {
            $fullText .= $page->content;
        }

        $words = TextHandler::getAllWordsFromText($fullText);
        $words = array_count_values(array_map('strtolower', $words));
        arsort($words);


        return view('reader.text_stats')->with('text', $text)->with('words', $words);
    }
}