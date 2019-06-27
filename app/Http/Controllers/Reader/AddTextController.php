<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextPage;
use App\Models\Reader\TextStats;
use App\Services\TextHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('reader.add_text');
    }

    public function addText(Request $request)
    {



        /**
         * load file
         * save text
         * split text to pages
         * save pages
         * calculate words
         * save text stats
         */

        // 1 - Load file
        $file = $request->file('textFile')->get();

        $textHandler = new TextHandler($file);

        // 2 - split text to pages

        $pages = $textHandler->splitTextToPages($file);

        DB::beginTransaction();

        // 3 - Save text to database

        $text = new Text();
        $text->title = $request->get('title');
        $text->language_id = 1;
        $text->user_id = Auth::user()->id;
        $text->total_pages = count($pages);
        $text->save();

        // 4 - Save text stats to database

        $textStats = new TextStats();
        $textStats->text_id = $text->id;
        $textStats->user_id = auth()->user()->id;
        $textStats->total_words = $textHandler->totalWords;
        $textStats->unique_words = $textHandler->uniqueWords;
        $textStats->known_words = $textHandler->knownWords;
        $textStats->unknown_words = $textHandler->unknownWords;
        $textStats->words = serialize($textHandler->words);
        $textStats->save();

        // 5 - save pages to database

        foreach ($pages as $page_number => $page)
        {
            $sentences = explode('.', $page);
            $finalContent = '';

            foreach ($sentences as $sentence)
            {
                $finalContent.= '<p>'.$sentence.'</p>'.PHP_EOL;
            }


            $textPage = new TextPage();
            $textPage->text_id = $text->id;
            $textPage->page_number = $page_number + 1; // because array starts from 0
            $textPage->content = $finalContent;
            $textPage->save();
        }

        DB::commit();

        return redirect()->route('reader_texts');











//        $path = $request->file('textFile')->store('txt');
//        $text = Storage::get($path);

        //$pages = $this->splitTextByLength($text, 1000);

//        var_dump(str_split($text, 1000));

//       var_dump($text);

      //  preg_match_all('#\b[^\s]+\b#i', $text, $output_array);

//        preg_match_all('#\b[^\s]+\b#ui', $text, $output_array);
//
//
//        $uniqueWords = array_unique($output_array[0]);
//
//        $result = array_count_values(array_map('strtolower', $output_array[0]));
//
//        arsort($result);
//
//        echo "TOTAL WORLDS - " . count($result) . '<br>';
//
//        foreach ($result as $word => $usageFrequency) {
//
//            echo ucfirst($word) . ' - ' . $usageFrequency. '<br>';
//
//        }

    }

}
