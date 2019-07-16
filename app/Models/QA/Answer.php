<?php

namespace App\Models\QA;

use App\Models\Main\User;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    public function user()
    {
        return $this->hasone(User::class, 'id', 'user_id');
    }
}
