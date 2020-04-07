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
        $pageNumber = $request->get('page') ? $request->get('page') : Text::findOrFail($textId)->current_page;

        // Get pages and current page

        $pages = TextPage::where('text_id', $textId)->paginate(1);
        $page = TextPage::where('text_id', $textId)->where('page_number', $pageNumber)->firstOrFail();

        // Get all user words

        $myWords = Word::where('state', WordConfig::KNOWN)->orWhere('state', WordConfig::TO_STUDY)->get();


        // декодировать текст страницы из base64
        // вокруг каждого слова добавить тег mark со стилем study или unknown и с data атрибутами

        $pageContent = base64_decode($page->content);
        $textHandler = new TextHandler($pageContent);

        // Handle page content

        //
        // Отсортировать масив со словами. Иначе регулярка будет криво работать

        // Первыми должны идти слова с апострофом и тире

        $startArray = $page->getMyWordsOnThisPage();
        $sortedArray = [];

        foreach ($startArray as $wordKey => $data) {

            if(preg_match("#[\'\-\_]#", $wordKey)) {
                $sortedArray[$wordKey] = $data;
            }
        }

        $finalArray = array_merge($sortedArray, $startArray);

        $myWordsOnThisPage = $page->getMyWordsOnThisPage();
        $pageContent = $textHandler->handleEnglishTextPage($finalArray);

        // Создать массив со всеми уникальными словами на этой странице
        $wordsToShow = [];

        // Add words from text to $wordsToShow array

        foreach ($textHandler->uniqueWords as $word) {
            $wordsToShow[$word[0]] = [
                'id' => null,
                'state' => null,
                'word' => $word[0],
                'translation' => null,
                'usage' => $word[1],
                'usage_percent' => $word[2]
            ];
        }

        $myWordsOnPagePage = $page->getMyWordsOnThisPage();

        foreach ($myWordsOnPagePage as $key => $data) {
            if(isset($wordsToShow[$key])) {
                $wordsToShow[$key]['id'] = $data['id'];
                $wordsToShow[$key]['state'] = $data['state'];
                $wordsToShow[$key]['translation'] = $data['translation'];
            }
        }

        // Update current text page

        $text = Text::find($page->text_id);
        $text->current_page = $pageNumber;
        $text->save();

        return view('text_page')
            ->with('page', $page)
            ->with('pages', $pages)
            ->with('pageContent', $pageContent)
            ->with('words', $wordsToShow)
            ->with('text', $page->text)
            ->with('text_id', $textId)
            ->with('current_page', $pageNumber);
    }


    public function showTextPageWordsPage(int $textId)
    {
        $currentPage = Text::findOrFail($textId)->current_page;
        $page = TextPage::where('text_id', $textId)->where('page_number', $currentPage)->firstOrFail();

        $pageContent = base64_decode($page->content);
        $textHandler = new TextHandler($pageContent);

        // Создать массив со всеми уникальными словами на этой странице
        $wordsToShow = [];

        // Add words from text to $wordsToShow array

        foreach ($textHandler->uniqueWords as $word) {
            $wordsToShow[$word[0]] = [
                'id' => null,
                'state' => null,
                'word' => $word[0],
                'translation' => null,
                'usage' => $word[1],
                'usage_percent' => $word[2]
            ];
        }

        $myWordsOnPagePage = $page->getMyWordsOnThisPage();

        foreach ($myWordsOnPagePage as $key => $data) {
            if(isset($wordsToShow[$key])) {
                $wordsToShow[$key]['id'] = $data['id'];
                $wordsToShow[$key]['state'] = $data['state'];
                $wordsToShow[$key]['translation'] = $data['translation'];
            }
        }

        return view('text_page_words')
            ->with('words', $wordsToShow)
            ->with('text_id', $textId)
            ->with('current_page', $currentPage);;
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
