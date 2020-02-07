<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'text';

    protected $settings = null;

    public function getWords()
    {
        return unserialize($this->words);
    }


    /**
     * @return array - просто массив со словами. обычные индексы в качестве ключей
     */
    public function getKnownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }


        $allMyWords = Word::where('lang_id', $this->lang_id)->whereHas('translation', function (Builder $query) {
            $query->where('lang_id', '=', $this->translate_to_lang_id);
        })->get();

        $myKnownWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean))

                $myKnownWordsInThisText[] = $myWord->word;
        }

        return $myKnownWordsInThisText;

    }

    /**
     * @return array - просто массив со словами. обычные индексы в качестве ключей
     */
    public function getUnknownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }


        $allMyWords = Word::where('lang_id', $this->lang_id)->whereHas('translation', function (Builder $query) {
            $query->where('lang_id', '=', $this->translate_to_lang_id);
        })->get();

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
