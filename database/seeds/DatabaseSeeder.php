<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $langs = [
            ['code' => 'af', 'title' => 'Afrikaans', 'eng_title' => 'Afrikaans'],
            ['code' => 'sq', 'title' => 'Shqiptar', 'eng_title' => 'Albanian'],
            ['code' => 'am', 'title' => 'አማርኛ', 'eng_title' => 'Amharic'],
            ['code' => 'ar', 'title' => 'عربى', 'eng_title' => 'Arabic'],
            ['code' => 'hy', 'title' => 'հHայերեն', 'eng_title' => 'Armenian'],
            ['code' => 'az', 'title' => 'Azərbaycan', 'eng_title' => 'Azerbaijani'],
            ['code' => 'eu', 'title' => 'Euskal', 'eng_title' => 'Basque'],
            ['code' => 'be', 'title' => 'Беларуская', 'eng_title' => 'Belarusian'],
            ['code' => 'bn', 'title' => 'বাঙালি', 'eng_title' => 'Bengali'],
            ['code' => 'bs', 'title' => 'Bosanski', 'eng_title' => 'Bosnian'],
            ['code' => 'bg', 'title' => 'Български', 'eng_title' => 'Bulgarian'],
            ['code' => 'ca', 'title' => 'Català', 'eng_title' => 'Catalan'],
            ['code' => 'ceb', 'title' => 'Cebuano', 'eng_title' => 'Cebuano'],
            ['code' => 'zh-CN', 'title' => '简体中文', 'eng_title' => 'Chinese (Simplified)'],
            ['code' => 'zh-TW', 'title' => '中國傳統的', 'eng_title' => 'Chinese (Traditional)'],
            ['code' => 'co', 'title' => 'Corsa', 'eng_title' => 'Corsican'],
            ['code' => 'hr', 'title' => 'Hrvatski', 'eng_title' => 'Croatian'],
            ['code' => 'cs', 'title' => 'Čeština', 'eng_title' => 'Czech'],
            ['code' => 'da', 'title' => 'Dansk', 'eng_title' => 'Danish'],
            ['code' => 'nl', 'title' => 'Nederlands', 'eng_title' => 'Dutch'],
            ['code' => 'en', 'title' => 'English', 'eng_title' => 'English'],
            ['code' => 'eo', 'title' => 'Esperanto', 'eng_title' => 'Esperanto'],
            ['code' => 'et', 'title' => 'Eesti keel', 'eng_title' => 'Estonian'],
            ['code' => 'fi', 'title' => 'Suomalainen', 'eng_title' => 'Finnish'],
            ['code' => 'fr', 'title' => 'Français', 'eng_title' => 'French'],
            ['code' => 'fy', 'title' => 'Frysk', 'eng_title' => 'Frisian'],
            ['code' => 'gl', 'title' => 'Galego', 'eng_title' => 'Galician'],
            ['code' => 'ka', 'title' => 'ქართული', 'eng_title' => 'Georgian'],
            ['code' => 'de', 'title' => 'Deutsche', 'eng_title' => 'German'],
            ['code' => 'el', 'title' => 'Ελληνικά', 'eng_title' => 'Greek'],
            ['code' => 'gu', 'title' => 'ગુજરાતી', 'eng_title' => 'Gujarati'],
            ['code' => 'ht', 'title' => 'Kreyòl Ayisyen', 'eng_title' => 'Haitian Creole'],
            ['code' => 'ha', 'title' => 'Hausa', 'eng_title' => 'Hausa'],
            ['code' => 'haw', 'title' => 'Ōlelo Hawaiʻi', 'eng_title' => 'Hawaiian'],
            ['code' => 'iw', 'title' => 'עברית', 'eng_title' => 'Hebrew'],
            ['code' => 'hi', 'title' => 'हिंदी', 'eng_title' => 'Hindi'],
            ['code' => 'hmn', 'title' => 'Hmoob', 'eng_title' => 'Hmong'],
            ['code' => 'hu', 'title' => 'Magyar', 'eng_title' => 'Hungarian'],
            ['code' => 'is', 'title' => 'Íslensku', 'eng_title' => 'Icelandic'],
            ['code' => 'ig', 'title' => 'Igbo', 'eng_title' => 'Igbo'],
            ['code' => 'id', 'title' => 'Bahasa Indonesia', 'eng_title' => 'Indonesian'],
            ['code' => 'ga', 'title' => 'Gaeilge', 'eng_title' => 'Irish'],
            ['code' => 'it', 'title' => 'Italiano', 'eng_title' => 'Italian'],
            ['code' => 'ja', 'title' => '日本人', 'eng_title' => 'Japanese'],
            ['code' => 'jw', 'title' => 'Jawa', 'eng_title' => 'Javanese'],
            ['code' => 'kn', 'title' => 'ಕನ್ನಡ', 'eng_title' => 'Kannada'],
            ['code' => 'kk', 'title' => 'Қазақша', 'eng_title' => 'Kazakh'],
            ['code' => 'km', 'title' => 'ភាសាខ្មែរ', 'eng_title' => 'Khmer'],
            ['code' => 'ko', 'title' => '한국어', 'eng_title' => 'Korean'],
            ['code' => 'ku', 'title' => 'Kurdî', 'eng_title' => 'Kurdish'],
            ['code' => 'ky', 'title' => 'Кыргызча', 'eng_title' => 'Kyrgyz'],
            ['code' => 'lo', 'title' => 'ລາວ', 'eng_title' => 'Lao'],
            ['code' => 'la', 'title' => 'Latine', 'eng_title' => 'Latin'],
            ['code' => 'lv', 'title' => 'Latviešu valoda', 'eng_title' => 'Latvian'],
            ['code' => 'lt', 'title' => 'Lietuvių', 'eng_title' => 'Lithuanian'],
            ['code' => 'lb', 'title' => 'Lëtzebuergesch', 'eng_title' => 'Luxembourgish'],
            ['code' => 'mk', 'title' => 'Македонски', 'eng_title' => 'Macedonian'],
            ['code' => 'mg', 'title' => 'Malagasy', 'eng_title' => 'Malagasy'],
            ['code' => 'ms', 'title' => 'Melayu', 'eng_title' => 'Malay'],
            ['code' => 'ml', 'title' => 'മലയാളം', 'eng_title' => 'Malayalam'],
            ['code' => 'mt', 'title' => 'Malti', 'eng_title' => 'Maltese'],
            ['code' => 'mi', 'title' => 'Maori', 'eng_title' => 'Maori'],
            ['code' => 'mr', 'title' => 'मराठी', 'eng_title' => 'Marathi'],
            ['code' => 'mn', 'title' => 'Монгол хэл дээр', 'eng_title' => 'Mongolian'],
            ['code' => 'my', 'title' => 'မြန်မာ', 'eng_title' => 'Myanmar (Burmese)'],
            ['code' => 'ne', 'title' => 'नेपाली', 'eng_title' => 'Nepali'],
            ['code' => 'no', 'title' => 'Norsk', 'eng_title' => 'Norwegian'],
            ['code' => 'ny', 'title' => 'Chichewa', 'eng_title' => 'Chichewa (Nyanja)'],
            ['code' => 'ps', 'title' => 'پښتو', 'eng_title' => 'Pashto'],
            ['code' => 'fa', 'title' => 'فارسی', 'eng_title' => 'Persian'],
            ['code' => 'pl', 'title' => 'Polskie', 'eng_title' => 'Polish'],
            ['code' => 'pt', 'title' => 'Português', 'eng_title' => 'Portuguese'],
            ['code' => 'pa', 'title' => 'ਪੰਜਾਬੀ', 'eng_title' => 'Punjabi'],
            ['code' => 'ro', 'title' => 'Română', 'eng_title' => 'Romanian'],
            ['code' => 'ru', 'title' => 'Русский', 'eng_title' => 'Russian'],
            ['code' => 'sm', 'title' => 'Samoa', 'eng_title' => 'Samoan'],
            ['code' => 'gd', 'title' => 'Gàidhlig na h-Alba', 'eng_title' => 'Scots Gaelic'],
            ['code' => 'sr', 'title' => 'Српски', 'eng_title' => 'Serbian'],
            ['code' => 'st', 'title' => 'Sesotho', 'eng_title' => 'Sesotho'],
            ['code' => 'sn', 'title' => 'Shona', 'eng_title' => 'Shona'],
            ['code' => 'sd', 'title' => 'سنڌي', 'eng_title' => 'Sindhi'],
            ['code' => 'si', 'title' => 'සිංහල', 'eng_title' => 'Sinhala'],
            ['code' => 'sk', 'title' => 'Slovenský', 'eng_title' => 'Slovak'],
            ['code' => 'sl', 'title' => 'Slovenščina', 'eng_title' => 'Slovenian'],
            ['code' => 'so', 'title' => 'Somali', 'eng_title' => 'Somali'],
            ['code' => 'es', 'title' => 'Español', 'eng_title' => 'Spanish'],
            ['code' => 'su', 'title' => 'Basa Sunda', 'eng_title' => 'Sundanese'],
            ['code' => 'sw', 'title' => 'Kiswahili', 'eng_title' => 'Swahili'],
            ['code' => 'sv', 'title' => 'Svenska', 'eng_title' => 'Swedish'],
            ['code' => 'tl', 'title' => 'Filipino', 'eng_title' => 'Filipino (Tagalog)'],
            ['code' => 'tg', 'title' => 'Тоҷикӣ', 'eng_title' => 'Tajik'],
            ['code' => 'ta', 'title' => 'தமிழ்', 'eng_title' => 'Tamil'],
            ['code' => 'te', 'title' => 'తెలుగు', 'eng_title' => 'Telugu'],
            ['code' => 'th', 'title' => 'ไทย', 'eng_title' => 'Thai'],
            ['code' => 'tr', 'title' => 'Türk', 'eng_title' => 'Turkish'],
            ['code' => 'uk', 'title' => 'Українська', 'eng_title' => 'Ukrainian'],
            ['code' => 'ur', 'title' => 'اردو', 'eng_title' => 'Urdu'],
            ['code' => 'uz', 'title' => 'O\'zbek', 'eng_title' => 'Uzbek'],
            ['code' => 'vi', 'title' => 'Tiếng Việt', 'eng_title' => 'Vietnamese'],
            ['code' => 'cy', 'title' => 'Cymraeg', 'eng_title' => 'Welsh'],
            ['code' => 'xh', 'title' => 'isiXhosa', 'eng_title' => 'Xhosa'],
            ['code' => 'yi', 'title' => 'Yiddish', 'eng_title' => 'Yiddish'],
            ['code' => 'yo', 'title' => 'Yorùbá', 'eng_title' => 'Yoruba'],
            ['code' => 'zu', 'title' => 'Zulu', 'eng_title' => 'Zulu'],
        ];




        foreach ($langs as $lang) {
            \App\Models\Main\Language::create([
                'code' => $lang['code'],
                'title' => $lang['title'],
                'eng_title' => $lang['eng_title'],
                'image' => $lang['image']
            ]);
        }
    }
}
