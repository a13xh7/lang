<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Show dashboard page with some user statistics
     */
    public function showDashboard()
    {
        return view('reader.dashboard');
    }


}
