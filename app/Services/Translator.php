<?php


namespace App\Services;


use Dejurin\GoogleTranslateForFree;

class Translator
{

    public static function translate($stringToTranslate)
    {
        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];

        $google = new GoogleTranslateForFree();
        $translation = $google->translate($learned_lang_code, $known_lang_code, $stringToTranslate);

        return $translation;
    }
}
