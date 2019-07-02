<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class GoogleTranslation extends Model
{
    protected $table = 'google_translations';

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
