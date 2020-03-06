<?php

namespace App\Http\Controllers;

use App\Config\WordConfig;
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

        // Get all user words

        $myWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->get();

        // Handle page content
        // декодировать текст страницы из base64
        // вокруг каждого слова добавить тег mark со стилем study или unknown и с data атрибутами

        $pageContent = base64_decode($page->content);
        $textHandler = new TextHandler($pageContent);

        // Передать в метод все слова (Word model) и получить массив в формате [word => state]
        $wordStateArray = $this->getWordStateArray($myWords);

        // Метод получает:
        // $userWords -
        //$pageContent = $textHandler->handleTextPage($wordStateArray, $myWords);

        $pageContent = $textHandler->handleEnglishTextPage($wordStateArray, $myWords);
        //dd($textHandler->handleEnglishTextPage($wordStateArray, $myWords));

        // Создать обычный массив со словами. [0 => word, 1 => word]
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
            ->with('words', $textHandler->uniqueWords)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords)
            ->with('text', $page->text);
    }

    /**
     * @param $userWords
     * @return array - array format ['word' => state]
     */
    private function getWordStateArray($userWords)
    {
        $result = [];
        foreach ($userWords as $userWord) {
            $result[$userWord->word] = $userWord->state;
        }
        return $result;
    }

}
