<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers;


use App\Models\Text;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextsController extends Controller
{

    public function showTexts()
    {
        $perPage = 10;

        $texts = Text::orderBy('id', 'DESC')->paginate($perPage);

        //$myWords = Word::where('lang_id', auth()->user()->id)->get();

        return view('reader.reader_texts')->with('texts', $texts);
    }

    public function updateText(Request $request)
    {
        $text = Text::find($request->get('text_id'));

        $text->title = $request->get('text_title');
        $text->lang_id = $request->get('lang_from');
        $text->translate_to_lang_id = $request->get('lang_to');
        $text->save();

        return redirect()->route('reader_texts');
    }

    public function deleteText(int $textId)
    {
        DB::beginTransaction();

        $text = Text::find($textId);
        $text->delete();

        DB::commit();

        return redirect()->route('reader_texts');
    }
}
