<?php

namespace App\Models\Main;

use App\Models\QA\Question;
use App\Models\Reader\Text;
use App\Models\Reader\Word;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'known_languages', 'studied_languages', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFirstKnownLanguage()
    {
        return unserialize($this->known_languages)[0];
    }

    public function getFirstStudiedLanguage()
    {
        return unserialize($this->studied_languages)[0];
    }

    public function getKnownLanguages()
    {
        return unserialize($this->known_languages);
    }

    public function getStudiedLanguages()
    {
        return unserialize($this->studied_languages);
    }

    public function texts()
    {
        return $this->belongsToMany(Text::class, 'user_text',  'user_id', 'text_id' )->withPivot('current_page');
    }

    public function words()
    {
        return $this->belongsToMany(Word::class, 'user_word',  'user_id', 'word_id' )->withPivot('state');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id', 'id');
    }

}
