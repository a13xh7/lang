<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/27/19
 * Time: 11:56 AM
 */

namespace App\Services;


use App\Config\WordConfig;
use App\Models\Reader\Word;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TextHandler
{
    /** @var string */
    public $text;
    /** @var int */
    public $totalWords = 0;
    /** @var int */
    public $totalUniqueWords = 0;
    /** @var int */
    public $totalSymbols = 0;

    /** @var array all words from text*/
    public $allWords = [];
    /** @var array all unique words from text*/
    public $uniqueWords = [];

    public function __construct($text)
    {
        $this->text = $text;

        // Find all words using regex

        $allWords = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/ui', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Add all words to array
        $this->allWords = $allWords;

        // Count and save unique words to array. Array format - ['word_key' => 'usage_frequency]
        $words = array_count_values(array_map('mb_strtolower', $this->allWords));
        arsort($words);

        // count usage frequency percent
        $this->totalWords = count($allWords);

        $wordsFinal = [];

        foreach ($words as $word => $usage_frequency) {

            $percent = round (($usage_frequency / $this->totalWords) * 100, 2);

            $wordsFinal[] = [$word, $usage_frequency, $percent];
        }

        $this->uniqueWords = $wordsFinal;

        // Set stats values

        $this->totalUniqueWords = count($this->uniqueWords);
        $this->totalSymbols = mb_strlen($this->text);

    }

    public function getUniqueWordsSerialized()
    {
        return serialize($this->uniqueWords);
    }


    public function splitTextToPages($pageLength = 2000)
    {
        $text = $this->text;
        $pages = [];

        while(!empty($text))
        {
            $pageEnd = $this->findPageEnd($pageLength);
            $pages[] = substr($text, 0, $pageEnd);

            $text = substr($text, $pageEnd, strlen($text) - 1);
        }

        return $pages;
    }

    public function handleTextPage(array $userWords, $wordsLangId, $translateToLangId):string
    {
        $userOnlyWords = array_keys($userWords);

        $wordRegex = "#\b[^\s]+\b#ui";
//        $wordRegex = "#\w+#ui";
//        dd(preg_match_all($wordRegex, $this->text));
//
//        preg_match_all('#[^\s0-9\.,\!\@\#\%]+#',  $this->text,$matches);
//
//        dd($matches);
// dd(preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/ui',  utf8_encode($this->text), -1, PREG_SPLIT_NO_EMPTY));

        $result = '';

        if(preg_match_all($wordRegex, $this->text) == false) {
            $wordRegex = "#[^\s0-9\.,\!\@\#\%]+#";
        } else {
            $wordRegex = "#\b[^\s]+\b#ui";
        }



        $result = preg_replace_callback($wordRegex,

            function ($matches) use ($userOnlyWords, $userWords, $wordsLangId, $translateToLangId)
            {

                $wordKey = mb_strtolower($matches[0]);

                if(in_array($wordKey, $userOnlyWords)) {

                    // если слово есть в массиве знакомых слов, проверить статус (знакомое или изучаемое)
                    if($userWords[$wordKey] == WordConfig::TO_STUDY ) {
                        $state = WordConfig::TO_STUDY;
                        return "<mark class='study' data-word='{$matches[0]}' data-state='{$state}' data-lang_id='{$wordsLangId}'  data-translate_to_lang_id='{$translateToLangId}'>{$matches[0]}</mark>"; // если слово изучаемое, выделить его оранжевым
                    } else {
                        return $matches[0]; // если слово знакомое, уже изученное, никак не выделять его
                    }

                } else {

                    $state = WordConfig::NEW;
                    return "<mark class='unknown' data-word='{$matches[0]}' data-state='{$state}' data-lang_id='{$wordsLangId}'  data-translate_to_lang_id='{$translateToLangId}'>{$matches[0]}</mark>"; // если слово незнакомое, выделить его
                }


            },

            $this->text);



        return $result;
    }




    private function findPageEnd($pageLength):int
    {
        $realLength = $pageLength;

        if(isset($this->text[$realLength]) === false)
        {
            return $pageLength;
        }

        while(
            $this->text[$realLength] !== '.'
            || $this->text[$realLength] !== '!'
            || $this->text[$realLength] !== '?'
            || $this->text[$realLength] !== '. '
            || $this->text[$realLength] !== ' ')

        {
            $realLength++;

            if(isset($this->text[$realLength]) === false)
            {
                return $pageLength;
            }


            if($realLength > $pageLength + 100) {
                break;
            }
        }

        return $realLength + 1; //  +1 means + dot
    }

    
    
}