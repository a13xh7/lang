<?php

namespace App\Http\Controllers\QA;

use App\Config\QuestionConfig;
use App\Http\Controllers\Controller;
use App\Models\QA\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function showQuestionsIndexPage(Request $request)
    {
        $perPage = 10;



        if(!Auth::guest()) {
            // get language from user model
        } else {
            // get language from browser
        }

        $questionsLanguage = $request->cookie('q_lang_id') == null ? 1 : 1;
        $questionsAboutLanguage = $request->cookie('q_about_lang_id');


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
