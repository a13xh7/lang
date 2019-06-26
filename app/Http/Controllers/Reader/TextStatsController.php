<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/26/19
 * Time: 7:10 PM
 */

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Reader\Text;
use App\Models\Reader\TextStats;
use Illuminate\Http\Request;

class TextStatsController extends Controller
{

    public function showTextStats(int $testId)
    {

        $text = Text::findOrFail($testId);

        return view('reader.text_stats')->with('text', $text);
    }
}