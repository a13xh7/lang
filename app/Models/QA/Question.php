<?php

namespace App\Models\QA;

use App\Models\Main\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';


    public function user()
    {
        return $this->hasone(User::class, 'id', 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
