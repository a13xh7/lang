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
        ['id' => '1', 'code' => 'af', 'title' => 'Afrikaans', 'eng_title' => 'Afrikaans'],
        ['id' => '2', 'code' => 'sq', 'title' => 'Shqiptar', 'eng_title' => 'Albanian'],
        ['id' => '3', 'code' => 'am', 'title' => 'አማርኛ', 'eng_title' => 'Amharic'],
        ['id' => '4', 'code' => 'ar', 'title' => 'عربى', 'eng_title' => 'Arabic'],
        ['id' => '5', 'code' => 'hy', 'title' => 'հայերեն', 'eng_title' => 'Armenian'],
        ['id' => '6', 'code' => 'az', 'title' => 'Azərbaycan', 'eng_title' => 'Azerbaijani'],
        ['id' => '7', 'code' => 'eu', 'title' => 'Euskal', 'eng_title' => 'Basque'],
        ['id' => '8', 'code' => 'be', 'title' => 'Беларуская', 'eng_title' => 'Belarusian'],
        ['id' => '9', 'code' => 'bn', 'title' => 'বাঙালি', 'eng_title' => 'Bengali'],
        ['id' => '10', 'code' => 'bs', 'title' => 'Bosanski', 'eng_title' => 'Bosnian'],
        ['id' => '11', 'code' => 'bg', 'title' => 'Български', 'eng_title' => 'Bulgarian'],
        ['id' => '12', 'code' => 'ca', 'title' => 'Català', 'eng_title' => 'Catalan'],
        ['id' => '13', 'code' => 'ceb', 'title' => 'Cebuano', 'eng_title' => 'Cebuano'],
        ['id' => '14', 'code' => 'zh-CN', 'title' => '简体中文', 'eng_title' => 'Chinese (Simplified)'],
        ['id' => '15', 'code' => 'zh-TW', 'title' => '中國傳統的', 'eng_title' => 'Chinese (Traditional)'],
        ['id' => '16', 'code' => 'co', 'title' => 'Corsa', 'eng_title' => 'Corsican'],
        ['id' => '17', 'code' => 'hr', 'title' => 'Hrvatski', 'eng_title' => 'Croatian'],
        ['id' => '18', 'code' => 'cs', 'title' => 'Čeština', 'eng_title' => 'Czech'],
        ['id' => '19', 'code' => 'da', 'title' => 'Dansk', 'eng_title' => 'Danish'],
        ['id' => '20', 'code' => 'nl', 'title' => 'Nederlands', 'eng_title' => 'Dutch'],
        ['id' => '21', 'code' => 'en', 'title' => 'English', 'eng_title' => 'English'],
        ['id' => '22', 'code' => 'eo', 'title' => 'Esperanto', 'eng_title' => 'Esperanto'],
        ['id' => '23', 'code' => 'et', 'title' => 'Eesti keel', 'eng_title' => 'Estonian'],
        ['id' => '24', 'code' => 'fi', 'title' => 'Suomalainen', 'eng_title' => 'Finnish'],
        ['id' => '25', 'code' => 'fr', 'title' => 'Français', 'eng_title' => 'French'],
        ['id' => '26', 'code' => 'fy', 'title' => 'Frysk', 'eng_title' => 'Frisian'],
        ['id' => '27', 'code' => 'gl', 'title' => 'Galego', 'eng_title' => 'Galician'],
        ['id' => '28', 'code' => 'ka', 'title' => 'ქართული', 'eng_title' => 'Georgian'],
        ['id' => '29', 'code' => 'de', 'title' => 'Deutsche', 'eng_title' => 'German'],
        ['id' => '30', 'code' => 'el', 'title' => 'Ελληνικά', 'eng_title' => 'Greek'],
        ['id' => '31', 'code' => 'gu', 'title' => 'ગુજરાતી', 'eng_title' => 'Gujarati'],
        ['id' => '32', 'code' => 'ht', 'title' => 'Kreyòl Ayisyen', 'eng_title' => 'Haitian Creole'],
        ['id' => '33', 'code' => 'ha', 'title' => 'Hausa', 'eng_title' => 'Hausa'],
        ['id' => '34', 'code' => 'haw', 'title' => 'Ōlelo Hawaiʻi', 'eng_title' => 'Hawaiian'],
        ['id' => '35', 'code' => 'iw', 'title' => 'עברית', 'eng_title' => 'Hebrew'],
        ['id' => '36', 'code' => 'hi', 'title' => 'हिंदी', 'eng_title' => 'Hindi'],
        ['id' => '37', 'code' => 'hmn', 'title' => 'Hmoob', 'eng_title' => 'Hmong'],
        ['id' => '38', 'code' => 'hu', 'title' => 'Magyar', 'eng_title' => 'Hungarian'],
        ['id' => '39', 'code' => 'is', 'title' => 'Íslensku', 'eng_title' => 'Icelandic'],
        ['id' => '40', 'code' => 'ig', 'title' => 'Igbo', 'eng_title' => 'Igbo'],
        ['id' => '41', 'code' => 'id', 'title' => 'Bahasa Indonesia', 'eng_title' => 'Indonesian'],
        ['id' => '42', 'code' => 'ga', 'title' => 'Gaeilge', 'eng_title' => 'Irish'],
        ['id' => '43', 'code' => 'it', 'title' => 'Italiano', 'eng_title' => 'Italian'],
        ['id' => '44', 'code' => 'ja', 'title' => '日本人', 'eng_title' => 'Japanese'],
        ['id' => '45', 'code' => 'jw', 'title' => 'Jawa', 'eng_title' => 'Javanese'],
        ['id' => '46', 'code' => 'kn', 'title' => 'ಕನ್ನಡ', 'eng_title' => 'Kannada'],
        ['id' => '47', 'code' => 'kk', 'title' => 'Қазақша', 'eng_title' => 'Kazakh'],
        ['id' => '48', 'code' => 'km', 'title' => 'ភាសាខ្មែរ', 'eng_title' => 'Khmer'],
        ['id' => '49', 'code' => 'ko', 'title' => '한국어', 'eng_title' => 'Korean'],
        ['id' => '50', 'code' => 'ku', 'title' => 'Kurdî', 'eng_title' => 'Kurdish'],
        ['id' => '51', 'code' => 'ky', 'title' => 'Кыргызча', 'eng_title' => 'Kyrgyz'],
        ['id' => '52', 'code' => 'lo', 'title' => 'ລາວ', 'eng_title' => 'Lao'],
        ['id' => '53', 'code' => 'la', 'title' => 'Latine', 'eng_title' => 'Latin'],
        ['id' => '54', 'code' => 'lv', 'title' => 'Latviešu valoda', 'eng_title' => 'Latvian'],
        ['id' => '55', 'code' => 'lt', 'title' => 'Lietuvių', 'eng_title' => 'Lithuanian'],
        ['id' => '56', 'code' => 'lb', 'title' => 'Lëtzebuergesch', 'eng_title' => 'Luxembourgish'],
        ['id' => '57', 'code' => 'mk', 'title' => 'Македонски', 'eng_title' => 'Macedonian'],
        ['id' => '58', 'code' => 'mg', 'title' => 'Malagasy', 'eng_title' => 'Malagasy'],
        ['id' => '59', 'code' => 'ms', 'title' => 'Melayu', 'eng_title' => 'Malay'],
        ['id' => '60', 'code' => 'ml', 'title' => 'മലയാളം', 'eng_title' => 'Malayalam'],
        ['id' => '61', 'code' => 'mt', 'title' => 'Malti', 'eng_title' => 'Maltese'],
        ['id' => '62', 'code' => 'mi', 'title' => 'Maori', 'eng_title' => 'Maori'],
        ['id' => '63', 'code' => 'mr', 'title' => 'मराठी', 'eng_title' => 'Marathi'],
        ['id' => '64', 'code' => 'mn', 'title' => 'Монгол хэл дээр', 'eng_title' => 'Mongolian'],
        ['id' => '65', 'code' => 'my', 'title' => 'မြန်မာ', 'eng_title' => 'Myanmar (Burmese)'],
        ['id' => '66', 'code' => 'ne', 'title' => 'नेपाली', 'eng_title' => 'Nepali'],
        ['id' => '67', 'code' => 'no', 'title' => 'Norsk', 'eng_title' => 'Norwegian'],
        ['id' => '68', 'code' => 'ny', 'title' => 'Chichewa', 'eng_title' => 'Chichewa (Nyanja)'],
        ['id' => '69', 'code' => 'ps', 'title' => 'پښتو', 'eng_title' => 'Pashto'],
        ['id' => '70', 'code' => 'fa', 'title' => 'فارسی', 'eng_title' => 'Persian'],
        ['id' => '71', 'code' => 'pl', 'title' => 'Polskie', 'eng_title' => 'Polish'],
        ['id' => '72', 'code' => 'pt', 'title' => 'Português', 'eng_title' => 'Portuguese'],
        ['id' => '73', 'code' => 'pa', 'title' => 'ਪੰਜਾਬੀ', 'eng_title' => 'Punjabi'],
        ['id' => '74', 'code' => 'ro', 'title' => 'Română', 'eng_title' => 'Romanian'],
        ['id' => '75', 'code' => 'ru', 'title' => 'Русский', 'eng_title' => 'Russian'],
        ['id' => '76', 'code' => 'sm', 'title' => 'Samoa', 'eng_title' => 'Samoan'],
        ['id' => '77', 'code' => 'gd', 'title' => 'Gàidhlig na h-Alba', 'eng_title' => 'Scots Gaelic'],
        ['id' => '78', 'code' => 'sr', 'title' => 'Српски', 'eng_title' => 'Serbian'],
        ['id' => '79', 'code' => 'st', 'title' => 'Sesotho', 'eng_title' => 'Sesotho'],
        ['id' => '80', 'code' => 'sn', 'title' => 'Shona', 'eng_title' => 'Shona'],
        ['id' => '81', 'code' => 'sd', 'title' => 'سنڌي', 'eng_title' => 'Sindhi'],
        ['id' => '82', 'code' => 'si', 'title' => 'සිංහල', 'eng_title' => 'Sinhala'],
        ['id' => '83', 'code' => 'sk', 'title' => 'Slovenský', 'eng_title' => 'Slovak'],
        ['id' => '84', 'code' => 'sl', 'title' => 'Slovenščina', 'eng_title' => 'Slovenian'],
        ['id' => '85', 'code' => 'so', 'title' => 'Somali', 'eng_title' => 'Somali'],
        ['id' => '86', 'code' => 'es', 'title' => 'Español', 'eng_title' => 'Spanish'],
        ['id' => '87', 'code' => 'su', 'title' => 'Basa Sunda', 'eng_title' => 'Sundanese'],
        ['id' => '88', 'code' => 'sw', 'title' => 'Kiswahili', 'eng_title' => 'Swahili'],
        ['id' => '89', 'code' => 'sv', 'title' => 'Svenska', 'eng_title' => 'Swedish'],
        ['id' => '90', 'code' => 'tl', 'title' => 'Filipino', 'eng_title' => 'Filipino (Tagalog)'],
        ['id' => '91', 'code' => 'tg', 'title' => 'Тоҷикӣ', 'eng_title' => 'Tajik'],
        ['id' => '92', 'code' => 'ta', 'title' => 'தமிழ்', 'eng_title' => 'Tamil'],
        ['id' => '93', 'code' => 'te', 'title' => 'తెలుగు', 'eng_title' => 'Telugu'],
        ['id' => '94', 'code' => 'th', 'title' => 'ไทย', 'eng_title' => 'Thai'],
        ['id' => '95', 'code' => 'tr', 'title' => 'Türk', 'eng_title' => 'Turkish'],
        ['id' => '96', 'code' => 'uk', 'title' => 'Українська', 'eng_title' => 'Ukrainian'],
        ['id' => '97', 'code' => 'ur', 'title' => 'اردو', 'eng_title' => 'Urdu'],
        ['id' => '98', 'code' => 'uz', 'title' => 'O\'zbek', 'eng_title' => 'Uzbek'],
        ['id' => '99', 'code' => 'vi', 'title' => 'Tiếng Việt', 'eng_title' => 'Vietnamese'],
        ['id' => '100', 'code' => 'cy', 'title' => 'Cymraeg', 'eng_title' => 'Welsh'],
        ['id' => '101', 'code' => 'xh', 'title' => 'isiXhosa', 'eng_title' => 'Xhosa'],
        ['id' => '102', 'code' => 'yi', 'title' => 'Yiddish', 'eng_title' => 'Yiddish'],
        ['id' => '103', 'code' => 'yo', 'title' => 'Yorùbá', 'eng_title' => 'Yoruba'],
        ['id' => '104', 'code' => 'zu', 'title' => 'Zulu', 'eng_title' => 'Zulu']
    ];

    public static function get($id)
    {
        return static::$languages[$id-1];
    }

    public static function all()
    {
        return static::$languages;
    }
}