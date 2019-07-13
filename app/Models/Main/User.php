<?php

namespace App\Models\Main;

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
        'name', 'email', 'password',
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


    public function texts()
    {
        return $this->belongsToMany(Text::class, 'user_text',  'user_id', 'text_id' )->withPivot('translate_to_lang_id', 'current_page');
    }

    public function words()
    {
        return $this->belongsToMany(Word::class, 'user_word',  'user_id', 'word_id' )->withPivot('state');
    }
}
