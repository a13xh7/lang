<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showUserSettingsPage()
    {
        $user = auth()->user();


        return view('main.main_user_settings')->with('user', $user);
    }


    public function updateUserSettings(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'unique:users,email_address,'.auth()->user()->id,
            'lang_known' => ['required'],
            'lang_learn' => ['required']
        ]);

        $user = User::find(auth()->user()->id);

        $user->name = $request->get('name');
        $user->email = $request->get('user_email');
        $user->known_languages = serialize( $request->get('lang_known') );
        $user->studied_languages = serialize( $request->get('lang_learn') );
        $user->save();

        return redirect()->back();
    }

    public function updateUserPassword()
    {

    }


    public function showPublicUserProfilePage()
    {
        
    }
}
