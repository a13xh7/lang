<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\TextPage;
use Illuminate\Http\Request;

class TextPageController extends Controller
{

    public function showPage(int $textId)
    {

        $pages = TextPage::where('text_id', $textId)->paginate(1);


        $page = TextPage::where('text_id', $textId)->where('page_number', $pages->currentPage())->first();



        return view('reader.text_read_page')->with('page', $page) ->with('pages', $pages);
    }

}
