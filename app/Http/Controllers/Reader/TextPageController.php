<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\Reader\TextPage;
use App\Services\TextHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextPageController extends Controller
{

    public function showPage(int $textId, Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        // Get pages and current page

        $pages = TextPage::where('text_id', $textId)->paginate(1);
        $page = TextPage::where('text_id', $textId)->where('page_number', $pages->currentPage())->firstOrFail();

        // Set languages

        $text_lang_id = $page->text->lang_id;
        $translate_to_lang_id = $user->texts()->find($textId)->pivot->translate_to_lang_id;

        // Get all user words.
        // Выбирать только слова язык которых совпадает я языком текста
        // и перевод которых совпадает с языком на который переводится текст

        $myWords = $user->words()->with('googleTranslation')->where('lang_id', $text_lang_id)->whereHas('googleTranslation', function (Builder $query) use ($translate_to_lang_id) {
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

        DB::table('user_text')
            ->where('user_id', auth()->user()->id)
            ->where('text_id', $page->text->id)
            ->update(['current_page' => $request->get('page')]);

        return view('reader.reader_text_page')
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
            $result[$userWord->word] = $userWord->pivot->state;
        }

        return $result;
    }

}
