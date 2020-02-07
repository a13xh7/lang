<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextPage extends Model
{
    public $timestamps = false;
    protected $table = 'text_page';

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
