<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'word';

    public function translation()
    {
        return $this->hasOne(Translation::class);
    }
}
