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

use Google\Cloud\Translate\TranslateClient;

class WordsController extends Controller
{

    public function showPage(Request $request)
    {
        $perPage = 100;

        $wordsLangId = $request->cookie('w_lang') != null ? $request->cookie('w_lang') : 0;
        $wordsTranslationLangId = $request->cookie('wt_lang') != null ? $request->cookie('wt_lang') : 0;

        // Достать слова из базы с учетом фильтров по языкам

        if($request->cookie('show_words') == WordConfig::TO_STUDY) {
            $words = Word::where('state', WordConfig::TO_STUDY)
                ->where('lang_id', $wordsLangId)
                ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->paginate($perPage);

        } elseif ($request->cookie('show_words') == WordConfig::KNOWN) {
            $words = Word::where('state', WordConfig::KNOWN)
                ->where('lang_id', $wordsLangId)
                ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
                })->paginate($perPage);

        } else {
            $words = Word::where('lang_id', $wordsLangId)
                ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                    $query->where('lang_id', '=', $wordsTranslationLangId);
            })->paginate($perPage);

        }


        // Посчитать количество слов с учетом фильтра по языкам

        $totalWords = Word::where('lang_id', $wordsLangId)
            ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();

        $totalKnownWords = Word::where('state', WordConfig::KNOWN)
            ->where('lang_id', $wordsLangId)
            ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
            })->count();

        $totalNewWords = Word::where('state', WordConfig::TO_STUDY)
            ->where('lang_id', $wordsLangId)
            ->whereHas('translation', function (Builder $query) use ($wordsTranslationLangId) {
                $query->where('lang_id', '=', $wordsTranslationLangId);
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
        // Если это новое слово, статус сразу меняется на TO_STUDY

        if($request->get('state') == 0) {
            $request->merge([
                'state' => WordConfig::TO_STUDY,
            ]);
        }

        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordLangId = $request->get('lang_id');
        $wordTranslateToLangId = $request->get('translate_to_lang_id');
        $wordState = $request->get('state');

        // Найти слово в базе по слову, языку и переводу

        $word = Word::where('word', $wordFromRequest)->where('lang_id', $wordLangId)
            ->whereHas('translation', function (Builder $query) use ($wordTranslateToLangId) {
                $query->where('lang_id', '=', $wordTranslateToLangId);
            })->first();


        if($word != null) {

            // Если перевод слова существует и если язык перевода равен языку на который переводится текст, вернуть перевод слова

            $existingTranslation = $word->translation;

            if($existingTranslation != null)
            {
                return $existingTranslation->translation;

            } else {

                // Иначе - достать перевод из гугла и сохранить его в базу

                $translate = new TranslateClient([
                    'keyFilePath' => base_path('WexLang-a2e92e316f89.json')
                ]);

                $result = $translate->translate('Русский', [
                    'source' => Lang::get($word->lang_id)['code'],
                    'target' => Lang::get($wordTranslateToLangId)['code']
                ]);

                // затем вернуть перевод

                return $result['text'];

            }

        } else {

            // Если слова нет в базе - добавить слово в базy

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->lang_id = $wordLangId;
            $word->state = $wordState;
            $word->save();

            // Перевести слово и сохранить перевод

            $google = new GoogleTranslateForFree();


            $translation = new Translation();
            $translation->word_id = $word->id;
            $translation->lang_id = $wordTranslateToLangId;
            $translation->translation = $google->translate(Lang::get($word->lang_id)['code'], Lang::get($wordTranslateToLangId)['code'], $wordFromRequest, 5);
            $translation->save();

            // вернуть перевод

            return $translation->translation;
        }


    }

    public function ajaxUpdateWordState(Request $request)
    {
        $word = Word::find($request->get('word_id'));
        $word->state = $request->get('state');
        $word->save();
    }

    public function ajaxUpdateWordStateFromPageReader(Request $request)
    {
        $word = Word::where('word', $request->get('word'))->where('lang_id', $request->get('lang_id'))
            ->whereHas('googleTranslation', function (Builder $query) use ($request) {
                $query->where('lang_id', '=', $request->get('translate_to_lang_id'));
            })->first();

        $word->users()->updateExistingPivot(auth()->user()->id, ['state' => WordConfig::KNOWN] );

        $word->save();
    }


    public function getTranslationFromDatabase(Request $request)
    {
        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordLangId = $request->get('lang_id');
        $wordTranslateToLangId = $request->get('translate_to_lang_id');

        $word = Word::where('word', $wordFromRequest)->where('lang_id', $wordLangId)->first();


        return $word->translation->translation;
    }
}
