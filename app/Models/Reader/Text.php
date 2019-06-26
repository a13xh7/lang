<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    public function textInfo()
    {
        return $this->hasOne('App\Models\Reader\TextStats', 'text_id', 'id');
    }
}
