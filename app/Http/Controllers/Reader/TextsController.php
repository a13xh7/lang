<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;


use App\Config\Lang;
use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\Reader\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextsController extends Controller
{

    public function showTexts()
    {

        $user = User::where('id', auth()->user()->id)->first();
        $texts = $user->texts()->where('public', false)->orderBy('id', 'DESC')->paginate(2);

        $myWords = $user->words()->where('user_id', auth()->user()->id)->get();





        return view('reader.reader_texts')->with('texts', $texts)->with('languages');
    }

    public function updateText(Request $request)
    {
        $text = Text::find($request->get('text_id'));

        $text->title = $request->get('text_title');
        $text->lang_id = $request->get('lang_from');
        $text->save();

        DB::table('user_text')
            ->where('user_id', auth()->user()->id)
            ->where('text_id', $text->id)
            ->update(['translate_to_lang_id' => $request->get('lang_to')]);

        return redirect()->route('reader_texts');
    }

    public function deleteText(int $textId)
    {
        DB::beginTransaction();

        $text = Text::find($textId);
        $text->users()->detach(auth()->user()->id);
        $text->delete();

        DB::commit();

        return redirect()->route('reader_texts');
    }
}