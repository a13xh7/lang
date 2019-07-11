<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/27/19
 * Time: 11:56 AM
 */

namespace App\Services;


use App\Models\Reader\Word;
use Illuminate\Support\Facades\DB;

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

    private $wordRegex = '#\b[^\s]+\b#ui';

    public function __construct($text)
    {
        $this->text = $text;

        // Find all words using regex
        preg_match_all($this->wordRegex, $text, $output_array);

        // Find all unique words
        $uniqueWords = array_unique($output_array[0]);

        // Add all words to array
        $this->allWords = $output_array[0];

        // Count and save unique words to array. Array format - ['word_key' => 'usage_frequency]
        $words = array_count_values(array_map('mb_strtolower', $this->allWords));
        arsort($words);
        $this->uniqueWords = $words;

        // Set stats values
        $this->totalWords = count($output_array[0]);
        $this->totalUniqueWords = count($uniqueWords);
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

    public function jkh()
    {

    }


    private function findPageEnd($pageLength):int
    {
        $realLength = $pageLength;

        if(isset($this->text[$realLength]) === false)
        {
            return $pageLength;
        }

        while($this->text[$realLength] !== '.'
            || $this->text[$realLength] !== '!'
            || $this->text[$realLength] !== '?'
            || $this->text[$realLength] !== '. ')
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