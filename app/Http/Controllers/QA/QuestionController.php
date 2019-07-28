<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\QA\Answer;
use App\Models\QA\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function showQuestionPage($questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->views = $question->views + 1;
        $question->save();

        $answers = Answer::where('question_id', $questionId)->get();

        $showAnswerForm = false;

        if(!Auth::guest()) {
            $userAnswer = Answer::where('user_id', auth()->user()->id)->where('question_id', $questionId)->get();
            $showAnswerForm = $userAnswer->isEmpty() ? true : false;
        }


        return view('qa.qa_question')
            ->with('question', $question)
            ->with('answers', $answers)
            ->with('showAnswerForm', $showAnswerForm);
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
