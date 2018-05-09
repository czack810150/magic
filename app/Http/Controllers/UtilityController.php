<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datetime;
use App\Employee;

class UtilityController extends Controller
{
    public function periods(Request $r)
    {
    	$periods = Datetime::calculatedPeriods($r->year);
    	return view('utility.periods',compact('periods'));
    }
    public function employeeByLocation(Request $r)
    {
       
        return Employee::ActiveAndVacationEmployees()->where('location_id',$r->location)->get();
    }
}
