<?php

namespace App\Models;

use App\Config\WordConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    public $timestamps = false;
    protected $table = 'text';

    protected $settings = null;

    /**
     * @return array
     * array structure
     * [
     *  0 => [ 0 => "the", 1 => 1804, 2 => 6.1381]
     *  1 => [ 0 => "test", 1 => 1322, 2 => 5.44]
     * ]
     * WHERE: 0 - a word, 1 - usage frequency, 2 - usage frequency (percent)
     */
    public function getWords()
    {
        return unserialize($this->words);
    }

    /**
     * @return array - just array [0 => 'word', 1 => 'word' , etc...]
     */
    public function getKnownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $allMyWords = Word::where('state', WordConfig::KNOWN)->get();

        $myKnownWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean))

                $myKnownWordsInThisText[] = $myWord->word;
        }

        return $myKnownWordsInThisText;
    }

    /**
     * @return array - just array [0 => 'word', 1 => 'word' , etc...]
     */
    public function getToStudyWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $allMyWords = Word::where('state', WordConfig::TO_STUDY)->get();

        $myToStudyWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean))

                $myToStudyWordsInThisText[] = $myWord->word;
        }

        return $myToStudyWordsInThisText;
    }

    /**
     * @return array - just array [0 => 'word', 1 => 'word' , etc...]
     */
    public function getKnownAndToStudyWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $allMyWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->get();

        $myWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean))

                $myWordsInThisText[] = $myWord->word;
        }

        return $myWordsInThisText;
    }

    public function getMyWordsInThisText()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $allMyWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->get();

        $myWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean)) {
                $myWordsInThisText[] = $myWord;
            }
        }

        return $myWordsInThisText;
    }

    /**
     * @return array - just array [0 => 'word', 1 => 'word' , etc...]
     */
    public function getUnknownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $allMyWords = Text::getMyWordsInThisText();

        $myWordsArray = [];
        foreach ($allMyWords as $myWord) {
            $myWordsArray[] = $myWord->word;
        }

        $myUnknownWordsInThisText = [];

        foreach ($textWordsClean as $textWord) {
            if(in_array($textWord, $myWordsArray) == false)

                $myUnknownWordsInThisText[] = $textWord;
        }

        return $myUnknownWordsInThisText;
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }


}
