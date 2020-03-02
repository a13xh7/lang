<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\TextPage;
use App\Services\FB2Parser;
use App\Services\TextHandler;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\PdfToText\Pdf;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('add_text')->with('languages');
    }

    public function addText(Request $request)
    {
        $pageLength = 2000;

        // 1 - Get uploaded text

        if ($request->file('text_file') != null) {

            // Validate file extension

            $exploded = explode('.', $request->file('text_file')->getClientOriginalName());
            $fileExtension = $exploded[count($exploded)-1];

            $allowedExtensions = ['txt', 'fb2', 'pdf'];

            if(in_array($fileExtension, $allowedExtensions) == false)
            {
                return redirect()->route('add_text_page')->withErrors(['input_name' => 'File extension is not supported']);
            }

            // extract text from file

            switch ($fileExtension) {
                case 'txt':
                    $text = $request->file('text_file')->get();
                    break;
                case 'fb2':
                    try {
                        $fb2 = new FB2Parser($request->file('text_file')->getRealPath());
                        $text = $fb2->getText();
                    } catch (\Exception $e) {
                        return redirect()->route('add_text_page')->withErrors(['input_name' => 'FB2 file parsing error']);
                    }
                    break;
                case 'pdf':
                    try {
                        $text = Pdf::getText($request->file('text_file')->getRealPath());
                    } catch (\Exception $e) {
                        return redirect()->route('add_text_page')->withErrors(['input_name' => 'PDF file parsing error']);
                    }
                    break;
            }
        } else {

            // Validate plain text form

            $request->validate([
                'text' => 'required',
            ]);

            // Get text from textarea if user didn't upload file

            $text = $request->get('text');
        }

        // 2 - split text to pages

        $textHandler = new TextHandler($text);
        $pages = $textHandler->splitTextToPages($pageLength);

        DB::beginTransaction();

            // 3 - Save text to database

            $text = new Text();
            $text->lang_id = $request->get('lang_from');
            $text->translate_to_lang_id = $request->get('lang_to');
            $text->title = $request->get('text_title');
            $text->total_pages = count($pages);
            $text->total_symbols = $textHandler->totalSymbols;
            $text->total_words = $textHandler->totalWords;
            $text->unique_words = $textHandler->totalUniqueWords;
            $text->words = $textHandler->getUniqueWordsSerialized();
            $text->save();

            // 4 - save pages to database

            foreach ($pages as $page_number => $page)
            {

                $textPage = new TextPage();
                $textPage->text_id = $text->id;
                $textPage->page_number = $page_number + 1; // because array starts from 0
                $textPage->content = base64_encode($page);
                $textPage->save();
            }

        DB::commit();

        return redirect()->route('texts');
    }
}
