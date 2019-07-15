<?php

namespace App\Http\Controllers\QA;

use App\Config\Group;
use App\Http\Controllers\Controller;
use App\Models\QA\Question;
use Illuminate\Http\Request;

class QuestionsIndexController extends Controller
{
    public function showPage()
    {
        $question = Question::where('group_id', Group::NO_GROUP)->paginate(2);

        return view('qa.qa_index')->with('questions', $question);
    }
}
