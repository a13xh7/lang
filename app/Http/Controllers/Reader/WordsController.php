<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Config\Lang;
use App\Config\WordConfig;
use App\Http\Controllers\Controller;
use App\Models\Main\User;

use App\Models\Reader\GoogleTranslation;
use App\Models\Reader\Word;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Dejurin\GoogleTranslateForFree;
use function MongoDB\BSON\toJSON;
use Stichoza\GoogleTranslate\GoogleTranslate;

class WordsController extends Controller
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


        return view('reader.reader_words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalNewWords);

    }


    public function ajaxAddNewWord(Request $request)
    {
        // Если это новое слово, статус сразу меняется на TO_STUDY

        if($request->get('state') == 0) {
            $request->merge([
                'state' => WordConfig::TO_STUDY,
            ]);
        }

        $user = User::where('id', auth()->user()->id)->first();

        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordLangId = $request->get('lang_id');
        $wordTranslateToLangId = $request->get('translate_to_lang_id');
        $wordState = $request->get('state');

        // Найти слово в базе по слову, языку и переводу

        $word = Word::where('word', $wordFromRequest)->where('lang_id', $wordLangId)
            ->whereHas('googleTranslation', function (Builder $query) use ($wordTranslateToLangId) {
                $query->where('lang_id', '=', $wordTranslateToLangId);
            })->first();


        if($word != null) {

            // Если слово существует, проверить есть ли оно у пользователя, который сейчас перевел его

            $userWord = $user->words()->where('word_id', $word->id)->first();

            // Если у пользователя нет этого слова. добавить пользователую слово. добавив запись в user_words table

            if($userWord == null) {
                $user->words()->attach( $word->id, ['state' => $wordState]);
            }

            // Если перевод слова существует и если язык перевода равен языку на который переводится текст, вернуть перевод слова

            //$existingTranslation = $word->googleTranslation()->where('word_id', $word->id)->where('lang_id', $wordTranslateToLangId)->get();

            $existingTranslation = $word->googleTranslation;

            if($existingTranslation != null)
            {
                return $existingTranslation->translation;

            } else {

                // Иначе - достать перевод из гугла и сохранить его в базу
                $google = new GoogleTranslateForFree();

                $translation = new GoogleTranslation();
                $translation->word_id = $word->id;
                $translation->lang_id = $wordTranslateToLangId;
                $translation->translation = $google->translate(Lang::get($word->lang_id)['code'], Lang::get($wordTranslateToLangId)['code'], $wordFromRequest, 5);
                $translation->save();

                // затем вернуть перевод

                return $translation->translation;

            }

        } else {

            // Если слова нет в базе - добавить слово в базе

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->lang_id = $wordLangId;
            $word->save();

            // Добавить это слово пользователю

            $word->users()->attach( auth()->user()->id, ['state' => $wordState]);

            // Перевести слово и сохранить перевод

            $google = new GoogleTranslateForFree();

            $translation = new GoogleTranslation();
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
        $word->users()->updateExistingPivot(auth()->user()->id, ['state' => $request->get('state')]);
        $word->save();
    }

    public function ajaxUpdateWordStateFromPageReader(Request $request)
    {
        $word = Word::where('word', $request->get('word'))->where('lang_id', $request->get('lang_id'))
            ->whereHas('googleTranslation', function (Builder $query) use ($request) {
                $query->where('lang_id', '=', $request->get('translate_to_lang_id'));
            })->first();

        $word->users()->updateExistingPivot(auth()->user()->id, ['state' => $request->get('state')]);
        $word->save();
    }


    public function getTranslationFromDatabase(Request $request)
    {
        $wordFromRequest = mb_strtolower($request->get('word'));
        $wordLangId = $request->get('lang_id');
        $wordTranslateToLangId = $request->get('translate_to_lang_id');

        $word = Word::where('word', $wordFromRequest)->where('lang_id', $wordLangId)->first();


        return $word->googleTranslation->translation;
    }
}