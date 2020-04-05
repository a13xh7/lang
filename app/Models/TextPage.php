<?php

namespace App\Models;

use App\Config\WordConfig;
use App\Services\TextHandler;
use Illuminate\Database\Eloquent\Model;

class TextPage extends Model
{
    public $timestamps = false;
    protected $table = 'text_page';

    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    public function getMyWordsOnThisPage()
    {
        $pageText = base64_decode($this->content);
        $textHandler = new TextHandler($pageText);
        $pageWords = $textHandler->uniqueWords;

        $pageWordsClean = [];

        foreach ($pageWords as $textWord) {
            $pageWordsClean[] = $textWord[0];
        }

        $myWordsOnThisPage = Word::whereIn('word', $pageWordsClean)->get();

        $result = [];

        foreach ($myWordsOnThisPage as $word) {
            $result[$word->word] = [
                'id' => $word->id,
                'state' => $word->state,
                'translation' => $word->translation
            ];
        }

        return $result;

//        $allMyWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->get();
//
//        $myKnownWordsInThisText = [];
//
//        foreach ($allMyWords as $myWord)
//        {
//            if(in_array($myWord->word, $pageWordsClean))
//            {
//                $myKnownWordsInThisText[$myWord->word] = [
//                'id' => $myWord->id,
//                'state' => $myWord->state,
//                'translation' => $myWord->translation
//                ];
//            }
//        }
//
//        return $myKnownWordsInThisText;
    }
}
