<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextPage;
use App\Services\TextHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('rt.rt_add_text');
    }


}
