<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\TextPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextPageController extends Controller
{

    public function showPage(int $textId, Request $request)
    {

        $pages = TextPage::where('text_id', $textId)->paginate(1);

        $page = TextPage::where('text_id', $textId)->where('page_number', $pages->currentPage())->first();




        DB::table('user_text')
            ->where('user_id', auth()->user()->id)
            ->where('text_id', $page->text->id)
            ->update(['current_page' => $request->get('page')]);


        return view('reader.text_read_page')->with('page', $page)->with('pages', $pages);
    }

}
