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
    /** @var int */
    public $totalWords = 0;
    /** @var int */
    public $uniqueWords = 0;
    /** @var array */
    public $words = [];  // ['word' => 10, 'word' => usageFrequency]

    public function __construct($text)
    {
        $wordRegex = '#\b[^\s]+\b#ui';
        preg_match_all($wordRegex, $text, $output_array);

        $this->totalWords = count($output_array[0]);

        $uniqueWords = array_unique($output_array[0]);

        $this->uniqueWords = count($uniqueWords);

        $this->setWords($uniqueWords);
    }


    public function splitTextToPages($text, $pageLength = 3000)
    {
        $pages = [];

        while(!empty($text))
        {
            $pageEnd = $this->findPageEnd($text, $pageLength);
            $pages[] = substr($text, 0, $pageEnd);

            $text = substr($text, $pageEnd, strlen($text) - 1);
        }

        return $pages;
    }


    private function findPageEnd($text, $pageLength)
    {

        $realLength = $pageLength;

        if(isset($text[$realLength]) === false)
        {
            return $pageLength;
        }

        while($text[$realLength] !== '.' )
        {
            $realLength++;

            if(isset($text[$realLength]) === false)
            {
                return $pageLength;
            }


            if($realLength > $pageLength + 100) {
                break;
            }
        }

        return $realLength + 1; //  +1 means + dot

    }


    private function setWords($allWords)
    {

        $words = array_count_values(array_map('strtolower', $allWords));
        arsort($words);

        $this->words = $words;

    }


}