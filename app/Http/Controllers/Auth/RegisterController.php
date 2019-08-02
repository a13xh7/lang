<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/reader/texts';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('main.main_register');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lang_known' => ['required'],
            'lang_learn' => ['required'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return mixed
     */
    protected function create(array $data)
    {

        return \App\Models\Main\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'known_languages' => serialize( $data['lang_known'] ),
            'studied_languages' => serialize( $data['lang_learn'] ),
            'password' => Hash::make($data['password']),
        ]);
    }
}
