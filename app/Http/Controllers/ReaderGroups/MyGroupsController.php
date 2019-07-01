<?php

namespace App\Http\Controllers\ReaderGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyGroupsController extends Controller
{
    public function showPage()
    {
        return view('reader_groups.my_groups');
    }
}
