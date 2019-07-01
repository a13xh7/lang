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
        $text = $request->file('textFile')->get();

        $textHandler = new TextHandler($text);

        // 2 - split text to pages

        $pages = $textHandler->splitTextToPages($text);

        DB::beginTransaction();

        // 3 - Save text to database

        $text = new Text();
        $text->lang_id = 1;
        $text->title = $request->get('title');
        $text->total_symbols = mb_strlen($request->file('textFile')->get());
        $text->total_pages = count($pages);
        $text->total_words = $textHandler->totalWords;
        $text->unique_words = $textHandler->uniqueWords;
        $text->words = serialize($textHandler->words);
        $text->save();

        // 4 - Save text settings to database

        $textSettings = new TextSettings();
        $textSettings->user_id = auth()->user()->id;
        $textSettings->text_id = $text->id;
        $textSettings->translate_to_lang_id = 1;
        $textSettings->current_page = 1;

        $textSettings->save();

        // Add row to user_text table

        DB::table('user_text')->insert([
            ['user_id' => auth()->user()->id, 'text_id' => $text->id]

        ]);


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




    }

}
