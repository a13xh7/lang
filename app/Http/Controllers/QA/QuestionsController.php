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


        if(Auth::guest() == false) {

            $user = \App\Models\Main\User::find(\auth()->user()->id);

            $questionsLanguage = $request->cookie('q_lang_id') != null ? $request->cookie('q_lang_id') : $user->getFirstKnownLanguage();
            $questionsAboutLanguage = $request->cookie('q_about_lang_id') != null ? $request->cookie('q_about_lang_id') : $user->getFirstStudiedLanguage();

        } else {

            $questionsLanguage = $request->cookie('q_lang_id') != null ? $request->cookie('q_lang_id') : 1;
            $questionsAboutLanguage = $request->cookie('q_about_lang_id') != null ? $request->cookie('q_about_lang_id') : 1;
        }



        $questions = Question::where('text_id', 0)
            ->where('lang_id', $questionsLanguage)
            ->where('about_lang_id', $questionsAboutLanguage)
            ->orderBy('id', 'DESC')->paginate($perPage);

        return view('qa.qa_index')
            ->with('questions', $questions)
            ->with('questionsLanguage',$questionsLanguage)
            ->with('questionsAboutLanguage',$questionsAboutLanguage);
    }

    public function showMyQuestions()
    {
        $perPage = 10;

        $question = Question::where('text_id', 0)->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate($perPage);

        return view('qa.qa_my_questions')->with('questions', $question);
    }


}
