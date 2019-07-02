<?php

namespace App\Models\Reader;

use App\Models\Main\User;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'words';

    public function googleTranslation()
    {
        return $this->hasOne(GoogleTranslation::class);
    }

    public function communityTranslations()
    {
        return $this->hasMany(CommunityTranslation::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_word',  'word_id', 'user_id' );
    }
}
