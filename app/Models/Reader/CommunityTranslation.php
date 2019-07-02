<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class CommunityTranslation extends Model
{
    protected $table = 'community_translations';

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
