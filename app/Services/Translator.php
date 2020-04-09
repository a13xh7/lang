<?php


namespace App\Services;


use App\Config\Config;
use Dejurin\GoogleTranslateForFree;
use Google\Cloud\Translate\V2\TranslateClient;

class Translator
{

    public static function translate($stringToTranslate)
    {
        if(!empty(Config::getApiKey()) && Config::getUseFreeTranslatorSetting() ==0) {
            return static::translateOfficial($stringToTranslate);
        }
        return static::translateFree($stringToTranslate);
    }


    // TRANSLATE FOR FREE - google may block you after some time
    public static function translateFree($stringToTranslate)
    {
        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];

        $google = new GoogleTranslateForFree();
        $translation = $google->translate($learned_lang_code, $known_lang_code, $stringToTranslate);

        return $translation;
    }


    // GOOGLE OFFICIAL TRANSLATE API
    public static function translateOfficial($stringToTranslate)
    {
        $learned_lang_code = \App\Config\Config::getLearnedLangData()['code'];
        $known_lang_code = \App\Config\Config::getKnownLangData()['code'];

        $translate = new TranslateClient([
            'key' => Config::getApiKey()
        ]);

        $result = $translate->translate($stringToTranslate, [
            'source' => $learned_lang_code,
            'target' => $known_lang_code
        ]);
        return $result['text'];
    }
}
