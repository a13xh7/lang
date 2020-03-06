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
        $words = Word::paginate($perPage);
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

        // Достать слова из базы с учетом фильтров по языкам

        if($showWordsFilter == WordConfig::TO_STUDY) {
            $words = Word::where('state', WordConfig::TO_STUDY)->paginate($perPage);
        } elseif ($showWordsFilter == WordConfig::KNOWN) {
            $words = Word::where('state', WordConfig::KNOWN)->paginate($perPage);
        } else {
            $words = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->paginate($perPage);
        }

        // Посчитать количество слов c разными статусами

        $totalWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->count();
        $totalKnownWords = Word::where('state', WordConfig::KNOWN)->count();
        $totalToStudyWords = Word::where('state', WordConfig::TO_STUDY)->count();

        return view('words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalToStudyWords);
    }

    public function ajaxAddOrUpdateWord(Request $request)
    {
        // Get word and word_state from request

        $wordId = $request->get('id') != null ? $request->get('id') : null;
        $wordState = $request->get('state');

        if($wordState == WordConfig::NEW) {
            $wordState = WordConfig::TO_STUDY;
        }

        $wordFromRequest = mb_strtolower($request->get('word'));

        // Find word in database

        $word = $wordId != null ? Word::find($wordId) : Word::where('word', $wordFromRequest)->first();

        // If word exists - update word state and add translation if there isn't one
        if($word != null) {

            // update word state

            $word->state = $wordState;
            $word->save();


            // Return translation if it exists
            if($word->translation != null)
            {
                return [$word->id, $word->translation];

            } else {
                // Translate word and save translation in there wasn't one

                $google = new GoogleTranslateForFree();

                $word->translation = $google->translate("en","ru", $wordFromRequest);
                $word->save();

                // Return translation
                return [$word->id, $word->translation];
            }

        } else {

            // Если слова нет в базе - перевести и добавить слово в базy

            $google = new GoogleTranslateForFree();

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->translation = $google->translate("en","ru", $wordFromRequest);
            $word->state = $wordState;
            $word->save();

            // вернуть перевод
            return [$word->id, $word->translation];
        }
    }




    public function ajaxAddNewWord(Request $request)
    {
        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordState = $request->get('state') == WordConfig::NEW ? WordConfig::TO_STUDY : $request->get('state');

        // Find word in database

        $word = Word::where('word', $wordFromRequest)->first();

        if($word != null) {

            // Если перевод слова существует, вернуть перевод слова

            if($word->translation != null)
            {
                return [$word->id, $word->translation];

            } else {

                // Если перевода нет перевести слово и сохранить перевод

                $google = new GoogleTranslateForFree();

                $word->translation = $google->translate("en","ru", $wordFromRequest);
                $word->save();

                // вернуть перевод
                return [$word->id, $word->translation];
            }

        } else {

            // Если слова нет в базе - перевести и добавить слово в базy

            $google = new GoogleTranslateForFree();

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->translation = $google->translate("en","ru", $wordFromRequest);
            $word->state = WordConfig::TO_STUDY;
            $word->save();

            // вернуть перевод
            return [$word->id, $word->translation];
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

}
