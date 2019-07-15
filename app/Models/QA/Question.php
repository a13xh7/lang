<?php

namespace App\Models\QA;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
