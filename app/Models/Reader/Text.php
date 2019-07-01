<?php

namespace App\Models\Reader;

use App\Models\Reader\TextSettings;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    /** @var TextSettings */
    protected $settings = null;

    public function textPages()
    {
        return $this->hasMany('App\Models\Reader\TextPage', 'text_id', 'id');
    }

    public function getSettings():?TextSettings
    {
        if($this->settings == null) {
            $settings = TextSettings::where('id', $this->id)->where('user_id', auth()->user()->id)->first();
        }

        return $settings;
    }
}
