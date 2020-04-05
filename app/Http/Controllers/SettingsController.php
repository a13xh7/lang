<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers;

use App\Config\Config;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{

    public function showPage()
    {
        $perPage = 5;
        $texts = Text::orderBy('id', 'DESC')->paginate($perPage);
        return view('settings');
    }

    public function updateSettings(Request $request)
    {
        $data = [
            "lang_i_learn_id" => $request->get("lang_i_learn_id"),
            "lang_i_know_id" => $request->get("lang_i_know_id"),
        ];

        $parsed_ini = parse_ini_file(Config::getPath(), true);
        $content = "";

        foreach($data as $key=>$value){
            $content .= $key."=".$value."\n";
        }

        //write it into file
        if (!$handle = fopen(Config::getPath(), 'w')) {
            return false;
        }
        $success = fwrite($handle, $content);
        fclose($handle);

        return redirect()->route('settings');
    }
}
