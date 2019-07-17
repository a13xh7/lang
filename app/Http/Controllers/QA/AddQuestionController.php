<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Models\Main\Language;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class AddQuestionController extends Controller
{
    public function showPage()
    {
        return view('qa.qa_add_question');
    }

    public function addQuestion(Request $request)
    {

        $question = new Question();

        $question->user_id = auth()->user()->id;
        $question->group_id = 0;
        $question->type = 0;
        $question->lang_from_id = $request->get('lang_from');
        $question->lang_to_id = $request->get('lang_to');
        $question->title = $request->get('title');
        $question->content = $request->get('content');
        $question->views = 0;
        $question->save();

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

        $question->lang_from_id = $request->get('lang_from');
        $question->lang_to_id = $request->get('lang_to');
        $question->title = $request->get('title');
        $question->content = $request->get('content');

        $question->save();

        return redirect()->route('qa_question', $question->id);
    }
}
