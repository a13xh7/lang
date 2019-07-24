<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use Illuminate\Http\Request;

class MyPublicTextsController extends Controller
{
    public function showPage()
    {
        $perPage = 10;

        $user = User::where('id', auth()->user()->id)->first();
        $texts = $user->texts()->where('public', true)->orderBy('id', 'DESC')->paginate($perPage);

        return view('rt.rt_my_texts')->with('texts', $texts);
    }

    public function deleteText($textId)
    {
        $user = User::where('id', auth()->user()->id)->first();

        $user->texts()->detach($textId);

        return redirect()->route('rt_my_texts');
    }
}
