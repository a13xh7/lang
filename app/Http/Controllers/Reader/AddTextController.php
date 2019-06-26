<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AddTextController extends Controller
{

    public function showPage()
    {
        return view('reader.add_text');
    }

    public function addText(Request $request)
    {

        /**
         * load file
         * save text
         * split text to pages
         * save pages
         * calculate words
         * save text stats
         */




//        $file = $request->file('textFile');
//        var_dump($file) ;


        $path = $request->file('textFile')->store('txt');
        $text = Storage::get($path);


       // preg_match_all('#\b[^\s]+\b#ui', $text, $output_array);

        preg_match_all('#\b[^\s]+\b#i', $text, $output_array);

        //$uniqueWords = array_unique($output_array[0]);

        $result = array_count_values(array_map('strtolower', $output_array[0]));

        arsort($result);

        echo "TOTAL WORLDS - " . count($result) . '<br>';

        foreach ($result as $word => $usageFrequency) {

            echo $word . ' - ' . $usageFrequency. '<br>';

        }

    }


    private function splitTextToPages($textFile):array
    {

    }

    private function calculateWords()
    {

    }
}
