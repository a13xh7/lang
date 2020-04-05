<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public $timestamps = false;
    protected $table = 'word';

    public function translations()
    {
        return $this->hasMany(Translation::class,'word_id', 'id');
    }

    public function getTranslation($translationLangId)
    {
        return Translation::where('word_id', $this->id)->where('lang_id', $translationLangId)->first();
    }

    public static function getAllCollocations() {
        $result = [];

        foreach (Word::all() as $word) {

            if (preg_match("#[\s]#", $word->word)) {
                $result[] = $word;
            }
        }

        return $result;
    }
}
