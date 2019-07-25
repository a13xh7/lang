<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\Reader\Text;
use Illuminate\Http\Request;

class PublicTextsController extends Controller
{
    public function showPage(Request $request)
    {
        $perPage = 10;
        $user = User::find(auth()->user()->id);

        $textsLangId = $request->cookie('pt_lang_id') != null ? $request->cookie('pt_lang') : $user->getFirstStudiedLanguage();
        $textsTranslateToLangId = $request->cookie('pt_to_lang_id') != null ? $request->cookie('pt_to_lang') : $user->getFirstKnownLanguage();

        $texts = Text::where('public', true)
            ->where('lang_id', $textsLangId)
            ->where('translate_to_lang_id', $textsTranslateToLangId)
            ->orderBy('id', 'DESC')->paginate($perPage);


        return view('rt.rt_public_texts')
            ->with('texts', $texts)
            ->with('textsLangId', $textsLangId)
            ->with('textsTranslateToLangId', $textsTranslateToLangId);
    }

    public function getPublicText($textId)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if( $user->texts()->find($textId) == null) {
            $user->texts()->attach($textId);
        }

        return redirect()->route('reader_read_text_page', [$textId, 'public=1']);
    }
}
