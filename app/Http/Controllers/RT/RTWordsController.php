<?php

namespace App\Http\Controllers\RT;

use App\Config\WordConfig;
use App\Http\Controllers\Controller;
use App\Models\Main\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RTWordsController extends Controller
{
    public function showPage(Request $request)
    {
        $perPage = 100;
        $wordsLangId = $request->cookie('w_lang');
        $wordsTranslationLangId = $request->cookie('wt_lang');

        $user = User::where('id', auth()->user()->id)->first();

        // Достать слова из базы с учетом фильтров по языкам

        if($request->cookie('show_words') == WordConfig::TO_STUDY)
        {
            $words = $user->words()
                ->where('state', WordConfig::TO_STUDY)
                ->where('lang_id', $wordsLangId)
                ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
                })->paginate($perPage);

        } elseif ($request->cookie('show_words') == WordConfig::KNOWN)
        {
            $words = $user->words()
                ->where('state', WordConfig::KNOWN)
                ->where('lang_id', $wordsLangId)
                ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
                })->paginate($perPage);

        } else
        {
            $words = $user->words()
                ->where('lang_id', $wordsLangId)
                ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
                })->paginate($perPage);
        }

        // Посчитать количество слов с учетом фильтра по языкам

        $totalWords = $user->words()
            ->where('lang_id', $wordsLangId)
            ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();

        $totalKnownWords = $user->words()
            ->where('state', WordConfig::KNOWN)
            ->where('lang_id', $wordsLangId)
            ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();

        $totalNewWords = $user->words()
            ->where('state', WordConfig::TO_STUDY)
            ->where('lang_id', $wordsLangId)
            ->whereHas('googleTranslation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();


        return view('rt.rt_words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalNewWords);
    }
}
