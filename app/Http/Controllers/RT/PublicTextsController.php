<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\Main\User;
use App\Models\Reader\Text;
use Illuminate\Http\Request;

class PublicTextsController extends Controller
{
    public function showPage()
    {
        $perPage = 10;

        $texts = Text::where('public', true)->orderBy('id', 'DESC')->paginate($perPage);

        return view('rt.rt_public_texts')->with('texts', $texts);
    }

    public function getPublicText($textId)
    {
        $user = User::where('id', auth()->user()->id)->first();

        $user->texts()->attach($textId);

        return redirect()->route('reader_read_text_page', $textId);
    }
}
