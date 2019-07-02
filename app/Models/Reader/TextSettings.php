<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class TextSettings extends Model
{
    protected $table = 'text_settings';

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
