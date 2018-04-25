<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datetime;

class UtilityController extends Controller
{
    public function periods(Request $r)
    {
    	$periods = Datetime::calculatedPeriods($r->year);
    	return view('utility.periods',compact('periods'));
    }
}
