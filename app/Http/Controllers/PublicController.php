<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function showIndexLanding()
    {
        return view('main.main_index_landing');
    }

    public function showReaderLanding()
    {
        return view('reader.reader_landing');
    }

    public function showReadTogetherLanding()
    {
        return view('rt.rt_landing');
    }
}
