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
        $languages = Language::all();
        return view('qa.add_question')->with('languages', $languages);
    }

    public function addQuestion(Request $request)
    {

        $question = new Question();

        $question->user_id = auth()->user()->id;
        $question->group_id = $request->get('group_id');
        $question->type = 0;
        $question->lang_from_id = $request->get('lang_from');
        $question->lang_to_id = $request->get('lang_to');
        $question->title = $request->get('title');
        $question->content = $request->get('content');
        $question->views = 0;
        $question->save();

        return redirect()->route('qa_index');
    }
}
