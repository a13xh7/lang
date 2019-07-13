<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextPage;
use App\Models\Reader\TextSettings;
use App\Services\TextHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('reader.reader_add_text')->with('languages');
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
        $text = $request->file('text_file')->get();

        $textHandler = new TextHandler($text);

        // 2 - split text to pages

        $pages = $textHandler->splitTextToPages();

        DB::beginTransaction();

        // 3 - Save text to database

        $text = new Text();
        $text->lang_id = $request->get('lang_from');
        $text->title = $request->get('text_title');
        $text->total_pages = count($pages);
        $text->total_symbols = $textHandler->totalSymbols;
        $text->total_words = $textHandler->totalWords;
        $text->unique_words = $textHandler->totalUniqueWords;
        $text->words = $textHandler->getUniqueWordsSerialized();

        $text->save();



        // Add row to user_text table
        $text->users()->attach(auth()->user()->id, ['translate_to_lang_id' => $request->get('lang_to')]);

        // 4 - Save text settings to database



        // 5 - save pages to database

        foreach ($pages as $page_number => $page)
        {
//            $sentences = explode('.', $page);
//            $finalContent = '';
//
//            foreach ($sentences as $sentence)
//            {
//                $finalContent.= '<p>'.$sentence.'</p>'.PHP_EOL;
//            }


            $textPage = new TextPage();
            $textPage->text_id = $text->id;
            $textPage->page_number = $page_number + 1; // because array starts from 0
            $textPage->content = $page;
            $textPage->save();
        }

        DB::commit();

        return redirect()->route('reader_texts');


    }

}
