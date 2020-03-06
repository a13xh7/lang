<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextsController extends Controller
{

    public function showTexts()
    {
        $perPage = 5;
        $texts = Text::orderBy('id', 'DESC')->paginate($perPage);
        return view('texts')->with('texts', $texts);
    }

    public function updateText(Request $request)
    {
        $text = Text::find($request->get('text_id'));
        $text->title = $request->get('text_title');
        $text->save();

        return redirect()->route('texts');
    }

    public function deleteText(int $textId)
    {
        DB::beginTransaction();
            $text = Text::find($textId);
            $text->delete();
        DB::commit();

        return redirect()->route('texts');
    }
}
