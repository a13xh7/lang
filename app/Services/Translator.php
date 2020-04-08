<?php


namespace App\Services;


use Dejurin\GoogleTranslateForFree;
use Google\Cloud\Translate\V2\TranslateClient;

class Translator
{

    // TRANSLATE FOR FREE - google may block you after some time

//    public static function translate($stringToTranslate)
//    {
//        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
//        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];
//
//        $google = new GoogleTranslateForFree();
//        $translation = $google->translate($learned_lang_code, $known_lang_code, $stringToTranslate);
//
//        return $translation;
//    }


    // GOOGLE CLOUD TRANSLATE API
    public static function translate($stringToTranslate)
    {
        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];

        $translate = new TranslateClient([
            'key' => 'AIzaSyA0w9GKt6mQZdg2i00zjIPEZKWnfBx7VFU'
        ]);

        $result = $translate->translate($stringToTranslate, [
            'source' => $learned_lang_code,
            'target' => $known_lang_code
        ]);

        return $result['text'];
    }
}
