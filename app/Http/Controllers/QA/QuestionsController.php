<?php

namespace App\Http\Controllers\QA;

use App\Config\QuestionConfig;
use App\Http\Controllers\Controller;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function showQuestionsIndexPage()
    {
        $perPage = 10;

        $question = Question::where('text_id', QuestionConfig::PUBLIC)->orderBy('id', 'DESC')->paginate($perPage);

        return view('qa.qa_index')->with('questions', $question);
    }

    public function showMyQuestions()
    {
        $perPage = 10;

        $question = Question::where('text_id', QuestionConfig::PUBLIC)->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate($perPage);

        return view('qa.qa_my_questions')->with('questions', $question);
    }


}
