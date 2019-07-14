<?php

namespace App\Models\Reader;

use App\Models\Main\Language;
use App\Models\Main\User;
use App\Models\Reader\TextSettings;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    /** @var TextSettings */
    protected $settings = null;

    public function getWords()
    {
        return unserialize($this->words);
    }

//    public function getKnownWords()
//    {
//        $textWords = $this->getWords();
//        $textWordsClean = [];
//
//        foreach ($textWords as $textWord) {
//            $textWordsClean[] = $textWord[0];
//        }
//
//
//        $user = User::where('id', auth()->user()->id)->first();
//        $allMyWords = $user->words()->where('user_id', auth()->user()->id)->get();
//
//        $allMyWordsArray = [];
//        foreach ($allMyWords as $myWord) {
//            $allMyWordsArray[] = $myWord->word;
//        }
//
//
//        //dd(array_intersect($textWordsClean, $allMyWordsArray));
//
//
//
//       return array_intersect($textWordsClean, $allMyWordsArray);
//
//    }

    public function getKnownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $user = User::where('id', auth()->user()->id)->first();
        $allMyWords = $user->words()->where('user_id', auth()->user()->id)->get();

        $myKnownWordsInThisText = [];

        foreach ($allMyWords as $myWord) {
            if(in_array($myWord->word, $textWordsClean))

                $myKnownWordsInThisText[] = $myWord->word;
        }

        return $myKnownWordsInThisText;

    }

    public function getUnknownWords()
    {
        $textWords = $this->getWords();
        $textWordsClean = [];

        foreach ($textWords as $textWord) {
            $textWordsClean[] = $textWord[0];
        }

        $user = User::where('id', auth()->user()->id)->first();
        $allMyWords = $user->words()->where('user_id', auth()->user()->id)->get();

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

//        $textWords = $this->getWords();
//        $textWordsClean = [];
//
//        foreach ($textWords as $textWord) {
//            $textWordsClean[] = $textWord[0];
//        }
//
//        $user = User::where('id', auth()->user()->id)->first();
//        $allMyWords = $user->words()->where('user_id', auth()->user()->id)->get();
//
//        $allMyWordsArray = [];
//        foreach ($allMyWords as $myWord) {
//            $allMyWordsArray[] = $myWord->word;
//        }
//
//        return array_diff($textWordsClean, $allMyWordsArray);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_text',  'text_id', 'user_id')->withPivot('translate_to_lang_id', 'current_page');;
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }

    public function settings():?TextSettings
    {
        if($this->settings == null) {
            $this->settings = TextSettings::where('id', $this->id)->where('user_id', auth()->user()->id)->first();
        }

        return $this->settings;
    }
}
