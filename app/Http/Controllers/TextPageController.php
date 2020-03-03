<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\TextPage;
use App\Models\Word;
use App\Services\TextHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TextPageController extends Controller
{
    public function showPage(int $textId, Request $request)
    {
        $pageNumber = $request->get('page') ? $request->get('page') : 1;

        // Get pages and current page

        $pages = TextPage::where('text_id', $textId)->paginate(1);
        $page = TextPage::where('text_id', $textId)->where('page_number', $pageNumber)->firstOrFail();

        // Set languages

        $text_lang_id = $page->text->lang_id;
        $translate_to_lang_id = $page->text->translate_to_lang_id;

        // Get all user words.
        // Выбирать только слова язык которых совпадает c языком текста
        // и перевод которых совпадает с языком на который переводится текст

        $myWords = Word::with('translations')
            ->where('lang_id', $text_lang_id)
            ->whereHas('translations', function (Builder $query) use ($translate_to_lang_id) {
            $query->where('lang_id', '=', $translate_to_lang_id);
        })->get();


        // Достать все уникальные слова из текущей страницы

        $userWords = $this->getWordStateArray($myWords, $translate_to_lang_id);

        // Handle page content
        // декодировать из base64, вокруг каждого слова добавить тег mark со стилем study или unknown

        $pageContent = base64_decode($page->content);
        $textHandler = new TextHandler($pageContent);
        $pageContent = $textHandler->handleTextPage($userWords, $text_lang_id, $translate_to_lang_id, $myWords);

        // Get user known words. Создать обычный массив со словами. [0 => word, 1 =>word]
        $knownWords = [];

        foreach ($myWords as $myWord) {
            $knownWords[] = $myWord->word;
        }


        // Update current text page

        $text = Text::find($page->text_id);
        $text->current_page = $pageNumber;
        $text->save();

        return view('text_page')
            ->with('page', $page)
            ->with('pages', $pages)
            ->with('pageContent', $pageContent)
            ->with('text_lang_id', $text_lang_id)
            ->with('translate_to_lang_id', $translate_to_lang_id)
            ->with('words', $textHandler->uniqueWords)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords)
            ->with('text', $page->text);
    }


    /**
     * @param $userWords
     * @return array - array format ['word' => state]
     */
    private function getWordStateArray($userWords, $translate_to_lang_id)
    {
        $result = [];
        foreach ($userWords as $userWord) {
            $result[$userWord->word] = $userWord->getTranslation($translate_to_lang_id)->state;
        }
        return $result;
    }

}
