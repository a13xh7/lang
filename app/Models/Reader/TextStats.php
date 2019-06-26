<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class TextStats extends Model
{
    protected $table = 'text_stats';

    public function text()
    {
        return $this->belongsTo('App\Models\Reader\Text');
    }
}
