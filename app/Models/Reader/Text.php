<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    public function textStats()
    {
        return $this->hasOne('App\Models\Reader\TextStats', 'text_id', 'id');
    }

    public function textPages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }
    
}
