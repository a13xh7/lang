<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers;

use App\Config\Lang;
use App\Config\WordConfig;
use App\Models\Translation;
use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Dejurin\GoogleTranslateForFree;

class WordsController extends Controller
{

    public function showAdminPage()
    {
        $perPage = 50;
        $words = Word::with('translations')->paginate($perPage);
        return view('words_admin')->with('words', $words);
    }

    public function showUploadDictionaryPage()
    {
        return view('words_upload_dictionary');
    }

    public function showPage(Request $request)
    {
        $perPage = 100;

        $showWordsFilter = $request->get('show_words') != null ? $request->get('show_words') : 0;
        $wordsLangId = $request->cookie('w_lang') != null ? $request->cookie('w_lang') : 0;
        $wordsTranslationLangId = $request->cookie('wt_lang') != null ? $request->cookie('wt_lang') : 0;

        // Достать слова из базы с учетом фильтров по языкам

        if($showWordsFilter == WordConfig::TO_STUDY) {
            $words = Word::where('lang_id', $wordsLangId)->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::TO_STUDY);
            })->paginate($perPage);

        } elseif ($showWordsFilter == WordConfig::KNOWN) {
            $words = Word::where('lang_id', $wordsLangId)
                ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::KNOWN);
                })->paginate($perPage);

        } else {
            $words = Word::where('lang_id', $wordsLangId)
                ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
            })->paginate($perPage);

        }

        // Посчитать количество слов с учетом фильтра по языкам

        $totalWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();

        $totalKnownWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::KNOWN);
            })->count();

        $totalNewWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::TO_STUDY);
            })->count();

        return view('words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalNewWords)
            ->with('wordsLangId', $wordsLangId)
            ->with('wordsTranslationLangId', $wordsTranslationLangId);
    }

    public function ajaxAddNewWord(Request $request)
    {
        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordLangId = $request->get('lang_id');
        $wordTranslateToLangId = $request->get('translate_to_lang_id');
        $wordState = $request->get('state') == WordConfig::NEW ? WordConfig::TO_STUDY : $request->get('state');

        // Find word in database

        $word = Word::where('word', $wordFromRequest)->where('lang_id', $wordLangId)->first();

        if($word != null) {

            // Если перевод слова на нужный язык существует, вернуть перевод слова

            $existingTranslation = Translation::where('word_id', $word->id)->where('lang_id', $wordTranslateToLangId)->first();

            if($existingTranslation != null)
            {
                return [$word->id, $existingTranslation->translation];

            } else {
                // Если нужного перевода нет перевести слово и сохранить перевод

                $google = new GoogleTranslateForFree();

                $translation = new Translation();
                $translation->word_id = $word->id;
                $translation->lang_id = $wordTranslateToLangId;
                $translation->translation = $google->translate(Lang::get($word->lang_id)['code'], Lang::get($wordTranslateToLangId)['code'], $wordFromRequest, 5);
                $translation->state = $wordState;
                $translation->save();

                // вернуть перевод
                return [$word->id, $translation->translation];
            }

        } else {

            // Если слова нет в базе - добавить слово в базy

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->lang_id = $wordLangId;
            $word->save();

            // Перевести слово и сохранить перевод

            $google = new GoogleTranslateForFree();

            $translation = new Translation();
            $translation->word_id = $word->id;
            $translation->lang_id = $wordTranslateToLangId;
            $translation->translation = $google->translate(Lang::get($word->lang_id)['code'], Lang::get($wordTranslateToLangId)['code'], $wordFromRequest, 5);
            $translation->state = $wordState;
            $translation->save();

            // вернуть перевод
            return [$word->id, $translation->translation];
        }
    }

    public function ajaxUpdateWordState(Request $request)
    {
        $wordId = $request->get('word_id');
        $wordState = $request->get('state');
        $translationLangId = $request->get('wt_lang_id');

        $translation = Translation::where('word_id', $wordId)->where('lang_id', $translationLangId)->first();
        $translation->state = $wordState;
        $translation->save();
    }

    public function ajaxDeleteWord(Request $request)
    {
       Word::find($request->get('word_id'))->delete();
    }

    public function ajaxDeleteTranslation(Request $request)
    {
        Translation::find($request->get('translation_id'))->delete();

    }
}
