<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextPage;
use App\Services\EpubParser;
use App\Services\FB2Parser;
use App\Services\TextHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('reader.reader_add_text')->with('languages');
    }

    public function addText(Request $request)
    {

        // 1 - Validate form

        $request->validate([
            'text_title' => 'required|max:255',
            'text_file' => 'max:10240',
        ]);


        // 2 - Validate file extension

        $exploded = explode('.', $request->file('text_file')->getClientOriginalName());
        $fileExtension = $exploded[count($exploded)-1];

        $allowedExtensions = ['txt', 'fb2', 'pdf'];
        if(in_array($fileExtension, $allowedExtensions) == false)
        {
            return redirect()->route('reader_add_text_page')->withErrors(['input_name' => 'File extension is not supported']);
        }


        // 3 - extract text from file

        switch ($fileExtension) {
            case 'txt':
                $text = $request->file('text_file')->get();
                break;
            case 'fb2':
                $fb2 = new FB2Parser($request->file('text_file')->getRealPath());
                $text = $fb2->getText();
                break;
            case 'pdf':
                $text = Pdf::getText($request->file('text_file')->getRealPath());
                break;
        }

        $textHandler = new TextHandler($text);

        // 2 - split text to pages

        $pages = $textHandler->splitTextToPages(1000);

        DB::beginTransaction();

        // 3 - Save text to database

        $text = new Text();
        $text->lang_id = $request->get('lang_from');
        $text->public = false;
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
            $textPage->content = base64_encode($page);
            $textPage->save();
        }

        DB::commit();

        return redirect()->route('reader_texts');


    }

}
