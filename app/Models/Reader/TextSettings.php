<?php

namespace App\Models\Reader;

use App\Models\Main\Language;
use Illuminate\Database\Eloquent\Model;

class TextSettings extends Model
{
    protected $table = 'text_settings';

    public function lang()
    {
        return $this->hasOne(Language::class, 'id', 'translate_to_lang_id');
    }

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
