<?php

namespace App\Models\Reader;

use App\Models\Main\Language;
use App\Models\Main\User;
use App\Models\Reader\TextSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

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

        $user = User::where('id', auth()->user()->id)->first();

        $translate_to_lang_id = $user->texts()->find($this->id)->pivot->translate_to_lang_id;

        $allMyWords = $user->words()->where('lang_id', $this->lang_id)->whereHas('googleTranslation', function (Builder $query) use ($translate_to_lang_id) {
            $query->where('lang_id', '=', $translate_to_lang_id);
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

        $user = User::where('id', auth()->user()->id)->first();

        $translate_to_lang_id = $user->texts()->find($this->id)->pivot->translate_to_lang_id;

        $allMyWords = $user->words()->where('lang_id', $this->lang_id)->whereHas('googleTranslation', function (Builder $query) use ($translate_to_lang_id) {
            $query->where('lang_id', '=', $translate_to_lang_id);
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_text',  'text_id', 'user_id')->withPivot('translate_to_lang_id', 'current_page');;
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }


}
