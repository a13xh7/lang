<?php

namespace App\Http\Controllers\RT;

use App\Config\QuestionConfig;
use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class MyTextQuestionsController extends Controller
{
    public function showPage()
    {
        $perPage = 10;
        $user = User::where('id', auth()->user()->id)->first();

        $questions = $user->questions()->where('text_id', '!=', 0)->orderBy('id', 'DESC')->paginate($perPage);


        return view('rt.rt_my_questions')->with('questions', $questions);
    }
}
