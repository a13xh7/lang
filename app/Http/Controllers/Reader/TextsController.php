<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextStats;
use Illuminate\Http\Request;

class TextsController extends Controller
{

    public function showTexts()
    {

        $texts = Text::paginate(10);

        return view('reader.texts')->with('texts', $texts);
    }

    public function updateText(int $textId)
    {
        \request()->get('text');

        redirect()->route('reader_texts');
    }

    public function deleteText(int $textId)
    {
        $text = Text::find($textId);

        $text->textStats->delete();

        foreach ($text->textPages as $textPage)
        {
            $textPage->delete();
        }

        $text->delete();

        return redirect()->route('reader_texts');
    }
}