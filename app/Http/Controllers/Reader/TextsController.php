<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Config\Group;
use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\Reader\Text;
use App\Models\Reader\TextStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextsController extends Controller
{

    public function showTexts()
    {

        $user = User::where('id', auth()->user()->id)->first();

        $texts = $user->texts()->where('group_id', Group::NO_GROUP)->paginate(10);

        return view('reader.texts')->with('texts', $texts);
    }

    public function updateText(int $textId)
    {
        \request()->get('text');

        redirect()->route('reader_texts');
    }

    public function deleteText(int $textId)
    {
        DB::beginTransaction();

        $text = Text::find($textId);

        $text->getSettings()->delete();

        foreach ($text->textPages as $textPage)
        {
            $textPage->delete();
        }


        DB::table('user_text')->where('user_id', auth()->user()->id)->where('text_id', $text->id)->delete();


        $text->delete();



        DB::commit();

        return redirect()->route('reader_texts');
    }
}