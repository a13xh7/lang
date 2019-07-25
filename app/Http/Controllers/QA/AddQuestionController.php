<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Models\Main\Language;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class AddQuestionController extends Controller
{
    public function showPage(Request $request)
    {
        $user = \App\Models\Main\User::find(\auth()->user()->id);

        $questionsLanguage = $request->cookie('q_lang_id') != null ? $request->cookie('q_lang_id') : $user->getFirstKnownLanguage();
        $questionsAboutLanguage = $request->cookie('q_about_lang_id') != null ? $request->cookie('q_about_lang_id') : $user->getFirstStudiedLanguage();


        return view('qa.qa_add_question')
            ->with('questionsLanguage',$questionsLanguage)
            ->with('questionsAboutLanguage',$questionsAboutLanguage);;
    }

    public function addQuestion(Request $request)
    {

        $textId = $request->get('text') ? $request->get('text') : 0;
        $page = $request->get('page') ? $request->get('page') : 0;

        $question = new Question();

        $question->user_id = auth()->user()->id;
        $question->text_id = $textId;
        $question->page = $page;
        $question->lang_id = $request->get('lang_from');
        $question->about_lang_id = $request->get('lang_to');
        $question->title = $request->get('title');
        $question->content = $request->get('content');
        $question->views = 0;
        $question->save();

        if($textId > 0) {
            return redirect()->route('rt_my_questions');
        }

        return redirect()->route('qa_index');
    }

    // EDIT

    public function showEditPage($questionId)
    {
        $question = Question::find($questionId);


        return view('qa.qa_edit_question')->with('question', $question);
    }

    public function updateQuestion(Request $request)
    {
        $question = Question::find($request->get('question_id'));

        $question->lang_id = $request->get('lang_from');
        $question->about_lang_id = $request->get('lang_to');
        $question->title = $request->get('title');
        $question->content = $request->get('content');

        $question->save();

        return redirect()->route('qa_question', $question->id);
    }
}
