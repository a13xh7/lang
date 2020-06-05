<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/27/19
 * Time: 11:56 AM
 */

namespace App\Services;

use App\Config\WordConfig;
use App\Models\Word;
use function foo\func;

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

        foreach ($words as $word => $usage_frequency)
        {
            $percent = round (($usage_frequency / $this->totalWords) * 100, 4);
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
            $pageEnd = $this->findPageEnd($text, $pageLength);
            $pages[] = substr($text, 0, $pageEnd);

            $text = substr($text, $pageEnd, strlen($text) - 1);
        }

        return $pages;
    }

    protected function handleCollocations()
    {
        $text = $this->text . PHP_EOL;

        foreach (Word::getAllCollocations() as $word)
        {
            $wordInRegex = preg_quote($word->word);
            $regex = "#(\b{$wordInRegex}\b)(?![^<]*>|[^<>]*<\/)#ui";
            $replacement = 'mark_tag';

            $translationArray =  preg_split("#[,;]#", $word->translation);
            $translation = htmlspecialchars(addslashes($translationArray[0]));

            // должен быть пробел в конце строки
            switch ($word->state) {
                case WordConfig::NEW:
                    $replacement = "<mark class='unknown' data-word='{$word->word}' data-state='{$word->state}' data-word_id='{$word->id}'><span class='translation' style='display: none;'>({$translation}) </span>{$word->word}</mark> ";
                    break;
                case WordConfig::TO_STUDY:
                    $replacement = "<mark class='study' data-word='{$word->word}' data-state='{$word->state}' data-word_id='{$word->id}'><span class='translation' style='display: none;'>({$translation}) </span>{$word->word}</mark> ";
                    break;
                case WordConfig::KNOWN:
                    $replacement = "<mark class='known' data-word='{$word->word}' data-state='{$word->state}' data-word_id='{$word->id}'><span class='translation' style='display: none;'>({$translation}) </span>{$word->word}</mark> ";
                    break;
            }
            $text = preg_replace($regex, $replacement, $text);
        };

        $this->text = $text;
    }

    /* //TODO
     * Доработка функции под английский язык
     * Нужно делать наоборот - доставать все слова из базы. Слово это регулярка, искать все повторения слова в тексте.
     * С этим вариантом будут работать фразовые глаголы и
     *
     */
    public function handleEnglishTextPage($myWords):string
    {
        // Сначала обработать модальные глаголы и прочие словосочетания

        $this->handleCollocations();

        $text = $this->text . PHP_EOL;
        $wordKeys = array_keys($myWords);
        $wordRegex = "#(\b[\w'’-]+\b)(?![^<]*>|[^<>]*<\/)#ui";

        // выделить все незнакомые слова.

        $text = preg_replace_callback($wordRegex, function ($matches) use ($wordKeys)
        {
            $word = $matches[0];

            // не выделять числа
            if(preg_match("#\b[0-9]+\b#", $word)) {
                return $word;
            }

            $data_word = trim(mb_strtolower($word));
            $state = WordConfig::NEW;

            if (!in_array($data_word, $wordKeys)) {
                return "<mark class='unknown' data-word=\"{$data_word}\" data-state='{$state}' >{$word}</mark>";
            }
            return $word;
        }, $text);

        // обработать слова которые уже есть в базе

        foreach ($myWords as $key => $data)
        {

            //$regex = "#(\b{$key}\b)(?![^<]*>|[^<>]*<\/)#ui";
            // #(\b{$wordInRegex}\b)($|\s|[^'])(?![^<]*>|[^<>]*<\/)#ui
            // "#(\b{$wordInRegex}\b)($|\s|[^'<>])(?![^<]*>|[^<>]*<\/)#ui"; - last
            $wordInRegex = preg_quote($key);
            $regex = "#(\b{$wordInRegex}\b)($|\s|[^'’<>?.!,;:()])?(?![^<]*>|[^<>]*<\/)#ui";
            $myWord = $myWords[$key];
            $translationArray = preg_split("#[,;]#", $myWord['translation']);
            $translation = htmlspecialchars(addslashes($translationArray[0]));

            if($key == "so") {
                //dd($translation);
            }
            $text = preg_replace_callback($regex, function ($matches) use ($myWord, $key, $translation)
            {
                $word = rtrim($matches[0]);
               //$word = $matches[0];
                switch ($myWord['state']) {
                    case WordConfig::NEW:
                        $replacement = "<mark class='unknown' data-word='{$key}' data-state='{$myWord['state']}' data-word_id='{$myWord['id']}'><span class='translation' style='display: none;'>({$translation}) </span>{$word}</mark> ";
                        break;
                    case WordConfig::TO_STUDY:
                        $replacement = "<mark class='study' data-word='{$key}' data-state='{$myWord['state']}' data-word_id='{$myWord['id']}'><span class='translation' style='display: none;'>({$translation}) </span>{$word}</mark> ";

                        break;
                    case WordConfig::KNOWN:
                        $replacement = "<mark class='known' data-word='{$key}' data-state='{$myWord['state']}' data-word_id='{$myWord['id']}' ><span class='translation' style='display: none;'>({$translation}) </span>{$word}</mark> ";
                        break;
                }

                return $replacement;
            }, $text);


        } // end foreach

        return $text;
    }

    private function findPageEnd($text, $pageLength):int
    {
        $realLength = $pageLength;

        if(isset($text[$realLength]) === false)
        {
            return $pageLength;
        }

        $pageEndOffset = strpos($text, '.', $realLength) != false ? strpos($text, '.', $realLength) : strpos($text, "\n", $realLength) ;

        return $pageEndOffset + 1; //  +1 means + dot
    }
}
