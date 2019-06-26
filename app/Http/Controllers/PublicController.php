<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function showIndexLanding()
    {
        return view('main.landing');
    }

    public function showReaderLanding()
    {
        return view('reader.landing');
    }
}
