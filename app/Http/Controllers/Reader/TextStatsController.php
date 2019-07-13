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
use App\Models\Reader\WordForStats;
use App\Services\TextHandler;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class TextStatsController extends Controller
{

    public function showTextStats(int $textId, Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $text = $user->texts()->find($textId);


        $words = $text->getWords();

        $knownWords = $text->getKnownWords();

        $myWords = $user->words()->where('user_id', auth()->user()->id)->get();


//        $words = new Paginator($words, 10);
//

//        //Get current page form url e.g. &page=6
//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//
//        //Create a new Laravel collection from the array data
//        $collection = new Collection($words);
//
//        //Define how many items we want to be visible in each page
//        $per_page = 100;
//
//        //Slice the collection to get the items to display in current page
//        $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
//
//        //Create our paginator and add it to the data array
//        $data = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
//
//        //Set base url for pagination links to follow e.g custom/url?page=6
//        $data->setPath($request->url());

//        $wordsAssoc = [];
//
//        foreach ($words as $word) {
//            $wordsAssoc[] = ['word' => $word[0], 'usage' => $word[1], 'percent' => $word[2]];
//        }
//
//        $words = new WordForStats($words);
//        $words = $words->paginate(100);

//        dd($test);

        return view('reader.reader_text_stats')
            ->with('text', $text)
            ->with('words', $words)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords);
    }
}