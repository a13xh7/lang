<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyTextsController extends Controller
{
    public function showPage()
    {
        return view('rt.rt_my_texts');
    }
}
