<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUserSettingsPage()
    {
        $user = auth()->user();


        return view('main.main_user_settings')->with('user', $user);
    }


    public function updateUserSettings(Request $request)
    {
dd($request);
    }

    public function updateUserPassword()
    {

    }


    public function showPublicUserProfilePAge()
    {
        
    }
}
