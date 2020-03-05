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
use Illuminate\Support\Facades\DB;

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

    public function deleteAllWords()
    {
        DB::beginTransaction();

        $words = Word::all();

        foreach ($words as $word) {
            $word->delete();
        }

        DB::commit();

        return redirect()->route('words_admin');
    }

    public function uploadDictionary(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '1024M');

        $wordsLangId = $request->get('words_lang_id');
        $wordsTranslationLangId = $request->get('translation_lang_id');

        $text = $request->file('text_file')->get();

        $words = json_decode($text);

        foreach ($words as $word => $translation) {

            $word = mb_strtolower($word);
            $translation = mb_strtolower($translation);

            $newWord = new Word;
            $newWord->word = $word;
            $newWord->lang_id = $wordsLangId;
            $newWord->save();

            $newTranslation = new Translation();
            $newTranslation->word_id = $newWord->id;
            $newTranslation->lang_id = $wordsTranslationLangId;
            $newTranslation->translation = $translation;
            $newTranslation->state = WordConfig::NEW;
            $newTranslation->save();


//            //достать слова чтобы не лезть в базу каждый раз
//            $myWords = Word::with('translations')
//                ->where('lang_id', $wordsLangId)
//                ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
//                    $query->where('lang_id', '=', $wordsTranslationLangId);
//                })->get();
//
//            $wordInDatabase = $myWords->where('word', $word)->where('lang_id', $wordsLangId)->first();
//
//            // Проверить есть ли слово в базе
//
//            if($wordInDatabase != null) {
//
//                // Проверить существует ли перевод на нужный язык
//                // Если перевода нет, добавить перевод из словаря
//
//                $existingTranslation = $myWords->translations
//                        ->where('word_id', $wordInDatabase->id)
//                        ->where('lang_id', $wordsTranslationLangId)->fist();
//
//               // $existingTranslation = Translation::where('word_id', $wordInDatabase->id)->where('lang_id', $wordsTranslationLangId)->first();
//
//                if($existingTranslation == null)
//                {
//                    $newTranslation = new Translation();
//                    $newTranslation->word_id = $wordInDatabase->id;
//                    $newTranslation->lang_id = $wordsTranslationLangId;
//                    $newTranslation->translation = $translation;
//                    $newTranslation->state = WordConfig::NEW;
//                    $newTranslation->save();
//                }
//
//            } else {
//                // Если слова нет в базе - добавить слово и перевод в базy
//
//                $newWord = new Word;
//                $newWord->word = $word;
//                $newWord->lang_id = $wordsLangId;
//                $newWord->save();
//
//                $newTranslation = new Translation();
//                $newTranslation->word_id = $newWord->id;
//                $newTranslation->lang_id = $wordsTranslationLangId;
//                $newTranslation->translation = $translation;
//                $newTranslation->state = WordConfig::NEW;
//                $newTranslation->save();
//            }
        }

        return redirect()->route('words_admin');
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
                    $query->where('lang_id', '=', $wordsTranslationLangId)
                        ->where('state', WordConfig::KNOWN)
                        ->orWhere('state', WordConfig::TO_STUDY);
                })->paginate($perPage);

        }

        // Посчитать количество слов с учетом фильтра по языкам

        $totalWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)
                    ->where('state', WordConfig::TO_STUDY)
                    ->orWhere('state', WordConfig::TO_STUDY);
            })->count();

        $totalKnownWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::KNOWN);
            })->count();

        $totalToStudyWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translations', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId)->where('state', WordConfig::TO_STUDY);
            })->count();

        return view('words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalToStudyWords)
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
