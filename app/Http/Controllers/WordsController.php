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
use App\Services\Translator;
use App\Services\XmlParser;
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

        $showWordsFilter = $request->get('show_words') != null ? $request->get('show_words') : 0;

        // Отфильтровать слова
        if($showWordsFilter) {
            $words = Word::where('state', $showWordsFilter)->paginate($perPage);
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

    public function exportToCsv()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=WexLangWords.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $words = Word::all();

        $callback = function() use ($words)
        {
            $columnNames = ['Word', 'Translation', 'State'];

            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($words as $word) {
                fputcsv($file, [$word->word, $word->translation, $word->state]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        ini_set('upload_max_filesize', '200M');
        ini_set('post_max_size','200M');

        // Validate file extension
        if ($request->file('text_file') != null) {
            $exploded = explode('.', $request->file('text_file')->getClientOriginalName());
            $fileExtension = $exploded[count($exploded) - 1];
            $allowedExtensions = ['csv'];

            if (in_array($fileExtension, $allowedExtensions) == false) {
                return redirect()->route('words_upload_dictionary')->withErrors(['input_name' => 'File extension is not supported']);
            }
        }

        $wordsFromFile = array_map('str_getcsv', file($request->file('text_file')));

        // Все слова из базы
        $myWords = Word::all();

        $wordsResult= [];
        foreach($wordsFromFile as $key => $data)
        {
            if($key == 0) {continue;}

            $word = $data[0];
            $translation = $data[1];
            $state = $data[2];

            $wordInDatabase = $myWords->where('word', $word)->first();

            if($wordInDatabase == null)
            {
                $wordsResult[] = [
                    'word' => mb_strtolower($word),
                    'translation' => mb_strtolower($translation),
                    'state' => $state,
                ];
            }
        }

        Word::insert($wordsResult);

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

                $word->translation = Translator::translate($wordFromRequest);
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
            $word->translation = Translator::translate($wordFromRequest);
            $word->state = $wordState;
            $word->save();

            // вернуть перевод
            return [$word->id, $word->translation];
        }
    }


//    public function ajaxAddNewWord(Request $request)
//    {
//        $wordFromRequest = mb_strtolower($request->get('word'));
//        $wordState = $request->get('state') == WordConfig::NEW ? WordConfig::TO_STUDY : $request->get('state');
//
//        // Find word in database
//
//        $word = Word::where('word', $wordFromRequest)->first();
//
//        if($word != null) {
//
//            // Если перевод слова существует, вернуть перевод слова
//
//            if($word->translation != null)
//            {
//                return [$word->id, $word->translation];
//
//            } else {
//
//                // Если перевода нет перевести слово и сохранить перевод
//
//                $google = new GoogleTranslateForFree();
//
//                $word->translation = $google->translate("en","ru", $wordFromRequest);
//                $word->save();
//
//                // вернуть перевод
//                return [$word->id, $word->translation];
//            }
//
//        } else {
//
//            // Если слова нет в базе - перевести и добавить слово в базy
//
//            $google = new GoogleTranslateForFree();
//
//            $word = new Word;
//            $word->word = $wordFromRequest;
//            $word->translation = $google->translate("en","ru", $wordFromRequest);
//            $word->state = WordConfig::TO_STUDY;
//            $word->save();
//
//            // вернуть перевод
//            return [$word->id, $word->translation];
//        }
//    }

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
        $handle = fopen("/home/alex/mp/lang/words.txt", "r");
        if ($handle) {

            $counter = 0;
            while (($line = fgets($handle)) !== false) {

                preg_match("#[a-z]+.*[a-z]+#ui", $line, $matches);

                $word = isset($matches[0]) ? $matches[0] : null;

                preg_match("#[а-я]+.*[а-я]#ui", $line,$matches);
                $translation = isset($matches[0]) ? $matches[0] : null;

                if($translation != null && $word!= null) {

                    $resultArray[$counter] = [mb_strtolower($word), mb_strtolower($translation), 0];
                    $counter++;
                }
            }
            fclose($handle);


//            foreach ( $resultArray as $key =>$data) {
//                echo $key . "     ". $data[1] . "<br>";
//            }

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=WexLangWords.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];



            $callback = function() use ($resultArray)
            {
                $columnNames = ['Word', 'Translation', 'State'];

                $file = fopen('php://output', 'w');
                fputcsv($file, $columnNames);
                foreach ($resultArray as $word) {
                    fputcsv($file, [$word[0]. rand(1,9999999), $word[1], 1]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);



        } else {
            echo "file error";
        }

    }

    public function xml()
    {
        $xml = simplexml_load_file("/home/alex/mp/lang/dict.xdxf");

//        $xml = simplexml_load_string("<ar><k>-em</k>
//(разговорное) сокр. от them - put 'em down положи их - up and at 'em, boys! бей их, ребята!</ar>");

//dd($xml->xpath('//ar')[0]->children()->__toString());

//        foreach ($xml->xpath('//ar') as $data) {
//
//            echo $data->children()->__toString() ." ---> ";
//            echo $data->__toString(). "<br><hr>";
//
//        }


        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=WexLangWords.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];



        $callback = function() use ($xml)
        {
            $columnNames = ['Word', 'Translation', 'State'];

            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($xml->xpath('//ar') as $data) {
                fputcsv($file, [$data->children()->__toString(), $data->__toString(), 1]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);








        return;
        ini_set("pcre.backtrack_limit", "10485760000");
        ini_set("pcre.recursion_limit", "10485760000");

        $xml = file_get_contents("/home/alex/mp/lang/dict.xdxf");

        preg_match_all('#<ar>(.|$|\s)+?<\/ar>#mui', $xml, $matches);

        foreach ($matches[0] as $match) {
            echo $match . "<br><hr>";
        }
    }
}
