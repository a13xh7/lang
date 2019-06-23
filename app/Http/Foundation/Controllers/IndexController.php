<?php

namespace App\Http\Foundation\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('foundation/index');
    }
}
