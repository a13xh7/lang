<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Models\QA\Answer;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function showQuestionPage($questionId)
    {
        $question = Question::find($questionId);
        $answers = Answer::where('question_id', $questionId)->get();

        return view('qa.question_page')->with('question', $question)->with('answers', $answers);
    }

    public function addAnswer(Request $request)
    {
        $answer = new Answer();
        $answer->user_id = $request->get('user_id');
        $answer->question_id = $request->get('question_id');
        $answer->content = $request->get('content');
        $answer->save();

        return redirect()->route('qa_question', $request->get('question_id'));
    }
}
