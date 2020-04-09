<?php


namespace App\Config;


class Config
{

    public static function getApiKey()
    {
        return Config::configArray()['api_key'];
    }

    public static function getUseFreeTranslatorSetting()
    {
        return Config::configArray()['use_free_translator'];
    }

    public static function getAppLangCode()
    {
        return Config::configArray()['app_lang'];
    }

    public static function getLearnedLangData()
    {
        return Lang::get(static::getLearnedLanguageId());
    }

    public static function getKnownLangData()
    {
        return Lang::get(static::getKnowLanguageId());
    }

    public static function getLearnedLanguageId()
    {
        return Config::configArray()['lang_i_learn_id'];
    }

    public static function getKnowLanguageId()
    {
        return Config::configArray()['lang_i_know_id'];
    }



    public static function getPath()
    {
        return base_path() . "/app_config.ini";
    }

    private static function configArray() {
        $config_array = parse_ini_file(base_path() . "/app_config.ini");
        return $config_array;
    }
}
