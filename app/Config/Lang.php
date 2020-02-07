<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/27/19
 * Time: 4:41 PM
 */

namespace App\Config;


class Lang
{
    private static $languages = [

        ['id' => '0', 'code' => 'en', 'title' => 'English', 'eng_title' => 'English'],
        ['id' => '1', 'code' => 'ru', 'title' => 'Русский', 'eng_title' => 'Russian'],
    ];

    public static function get($id)
    {
        return static::$languages[$id];
    }

    public static function all()
    {
        return static::$languages;
    }
}
