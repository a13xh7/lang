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
use Mockery\Exception;

class WordsController extends Controller
{
    public function showPage(Request $request)
    {
        $wordToFind = $request->get("word_to_find");
        $perPage = 100;

        $showWordsFilter = $request->get('show_words') != null ? $request->get('show_words') : null;

        // Отфильтровать слова
        if($showWordsFilter) {
            $words = Word::where('state', WordConfig::TO_STUDY)->paginate($perPage);
        }
        else {
            $words = Word::paginate($perPage);
        }

        // Найти слово если нужно. Если используется поиск слова, фильтры не учитываются
        if($wordToFind != null) {
            $words = Word::where('word', 'like', $wordToFind.'%')->paginate($perPage);
        }

        // Посчитать количество слов c разными статусами

        $totalWords = Word::count();
        $totalKnownWords = Word::where('state', WordConfig::KNOWN)->count();
        $totalToStudyWords = Word::where('state', WordConfig::TO_STUDY)->count();

        return view('words')
            ->with('words', $words)
            ->with('totalWords', $totalWords)
            ->with('totalKnownWords', $totalKnownWords)
            ->with('totalNewWords', $totalToStudyWords);
    }

    public function showUploadDictionaryPage()
    {
        return view('words_upload_dictionary');
    }

    public function addNewWord(Request $request)
    {
        $word = Word::where('word', $request->get('new_word') )->first();

        if($word != null) {
            $word->translation = $request->get('new_translation');
            $word->state = $request->get('new_word_state');
            $word->save();
            return redirect()->route('words');
        }

        $newWord = new Word;
        $newWord->word = $request->get('new_word');
        $newWord->translation = $request->get('new_translation');
        $newWord->state = $request->get('new_word_state');
        $newWord->save();

        return redirect()->route('words');
    }

    public function deleteAllWords()
    {
        DB::beginTransaction();

        $words = Word::all();

        foreach ($words as $word) {
            $word->delete();
        }

        DB::commit();

        return redirect()->route('words');
    }

    public function uploadDictionary(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '1024M');

        $text = $request->file('text_file')->get();

        $words = json_decode($text);

        // Все слова из базы
        $myWords = Word::all();

        $wordsFromFile = [];
        foreach($words as $word => $translation)
        {
            $wordInDatabase = $myWords->where('word', $word)->first();

            if($wordInDatabase == null)
            {
                $wordsFromFile[] = [
                    'word' => mb_strtolower($word),
                    'translation' => mb_strtolower($translation),
                    'state' => 0,
                ];
            }
        }

        Word::insert($wordsFromFile);

        return redirect()->route('words');
    }

    public function ajaxAddOrUpdateWord(Request $request)
    {
        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];

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

                $word->translation = $google->translate($learned_lang_code, $known_lang_code, $wordFromRequest);
                $word->save();

                // Return translation
                return [$word->id, $word->translation];
            }

        } else {

            // Если слова нет в базе - перевести и добавить слово в базy

            if($wordFromRequest == null) {
                return ["empty_word", "empty_word"];
            }

            $google = new GoogleTranslateForFree();

            $word = new Word;
            $word->word = $wordFromRequest;
            $word->translation = $google->translate($learned_lang_code, $known_lang_code, $wordFromRequest);
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

    public function ajaxGetWordTranslation(Request $request)
    {
        $wordId = $request->get('word_id');
        $word = Word::find($wordId);

        if($word == null) {
            return  'no_word_in_DB';
        }
        return  $word->translation;
    }

    public function ajaxUpdateWordTranslation(Request $request)
    {
        $wordId = $request->get('word_id');

        $word = Word::find($wordId);

        if($word == null) {
            return ['error', 'error'];
        }

        $word->translation = $request->get('word_translation');
        $word->save();

        return [$word->id, $word->translation];
    }

    public function ajaxDeleteWord(Request $request)
    {
       Word::find($request->get('word_id'))->delete();
    }

    public function generate()
    {
        $resultArray = [];
        $handle = fopen("/home/alex/mp/lang/3000_list.txt", "r");
        if ($handle) {

            while (($line = fgets($handle)) !== false) {


                preg_match("#[a-z]+.*[a-z]+#ui", $line, $matches);

                $word = isset($matches[0]) ? $matches[0] : null;

                preg_match("#[а-я]+.*[а-я]#ui", $line,$matches);
                $translation = isset($matches[0]) ? $matches[0] : null;

                if($translation != null && $word!= null) {
                    $resultArray[$word] = $translation;
                }
            echo $word . "<br>";
            }

            fclose($handle);
        } else {
            echo "file error";
        }

        //return json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    }


}
