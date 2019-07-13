<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Model;

class WordForStats extends Model
{
    protected $table = 'words';
    protected $fillable = ['word', 'usage', 'percent'];


}
