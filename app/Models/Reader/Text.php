<?php

namespace App\Models\Reader;

use App\Models\Main\Language;
use App\Models\Main\User;
use App\Models\Reader\TextSettings;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    /** @var TextSettings */
    protected $settings = null;

    public function lang()
    {
        return $this->hasOne(Language::class, 'id', 'lang_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_text',  'text_id', 'user_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }

    public function settings():?TextSettings
    {
        if($this->settings == null) {
            $this->settings = TextSettings::where('id', $this->id)->where('user_id', auth()->user()->id)->first();
        }

        return $this->settings;
    }
}
