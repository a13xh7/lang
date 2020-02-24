<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Models\TextPage;
use App\Models\Word;
use App\Services\TextHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextPageController extends Controller
{
    public function showPage(int $textId, Request $request)
    {
        $pageNumber = $request->get('page') ? $request->get('page') : 1;

        // Get pages and current page

        $pages = TextPage::where('text_id', $textId)->paginate(1);
        $pages->appends(request()->except('wtf'));

        $page = TextPage::where('text_id', $textId)->where('page_number', $pages->currentPage())->firstOrFail();

        // Set languages

        $text_lang_id = $page->text->lang_id;
        $translate_to_lang_id = $page->text->translate_to_lang_id;

        // Get all user words.
        // Выбирать только слова язык которых совпадает я языком текста
        // и перевод которых совпадает с языком на который переводится текст

        $myWords = Word::with('translation')->where('lang_id', $text_lang_id)->whereHas('translation', function (Builder $query) use ($translate_to_lang_id) {
            $query->where('lang_id', '=', $translate_to_lang_id);
        })->get();


        // Handle page content
        // декодировать из base64, вокруг каждого слова добавить тег mark со стилем study или unknown
        // Доставть все уникальные слова из текущей страницы

        $pageContent = base64_decode($page->content);
        $textHandler = new TextHandler($pageContent);

        $userWords = $this->getUserWordsArray($myWords);

        $pageContent = $textHandler->handleTextPage($userWords, $text_lang_id, $translate_to_lang_id, $myWords);

        // Get user known words
        // Создать обычный массив со словами. без ключей, только слова

        $knownWords = [];

        foreach ($myWords as $myWord) {
            $knownWords[] = $myWord->word;
        }

        // Update current text page

        DB::table('text')
            ->where('text_id', $page->text->id)
            ->update(['current_page' => $pageNumber]);


        return view('text_page')
            ->with('page', $page)
            ->with('pages', $pages)
            ->with('pageContent', $pageContent)
            ->with('text_lang_id', $text_lang_id)
            ->with('translate_to_lang_id', $translate_to_lang_id)
            ->with('words', $textHandler->uniqueWords)
            ->with('knownWords', $knownWords)
            ->with('myWords', $myWords);
    }


    /**
     * @param $userWords
     * @return array - array format ['word' => state]
     */
    private function getUserWordsArray($userWords)
    {
        $result = [];

        foreach ($userWords as $userWord) {
            $result[$userWord->word] = $userWord->state;
        }

        return $result;
    }

}
