<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'show_words',
        'w_lang',
        'wt_lang',
        'q_lang_id',
        'q_about_lang_id',
        'pt_lang_id',
        'pt_to_lang_id'
    ];
}
