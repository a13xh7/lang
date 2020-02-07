<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translation';

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
