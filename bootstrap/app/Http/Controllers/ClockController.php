<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Shift;
use App\Clock;
use App\In;
use Carbon\Carbon;
date_default_timezone_set("America/Toronto");
class ClockController extends Controller
{

    public function index(){
   
        return view('shift.timeclock.inout'); 	
    }
    public function in(){
    	return view('shift.timeclock.clockin');
    }
    public function out(){
    	return view('shift.timeclock.clockout');
    }
    public function clockIn()
    {
      $auth = Auth::user()->authorization;
      if($auth->type === 'location'){
        $location = $auth->location->id;
      } else {

      }

    	$this->validate(request(),[
    		'employeeCard' => 'required',
    		]);
    	
    	$employee = $this->findEmployee(request('employeeCard'));

    	if(!$employee){
    		return view('shift.timeclock.notEmployee');
    	}
    	if($employee->status != 'active'){
    		return view('shift.timeclock.notActiveEmployee',compact('employee'));
    	}
      
    	$inout = true; //clock in or out;
    	$now = Carbon::now();
    	
   		$shifts = Shift::where('employee_id',$employee->id)->whereDate('start',$now->toDateString())->get();	
   		$result = false;

      $inShift = In::where('employee_id',$employee->id)->first();
   	
   		if(is_null($inShift)){ // no record today, clock in
   	    	$clockIn = $this->clockEmployee($location,$employee->id,$now,$inout,''); // new clock record
          $result = true;
   		} 
   	
    	  $records = Clock::where('employee_id',$employee->id)->whereDate('clockIn',$now->toDateString())->get();
        $forgotten  = Clock::where('employee_id',$employee->id)->whereDate('clockIn','<',$now->toDateString())->where('clockOut',null)->orderby('clockIn','desc')->first();
        $message = "You can do it!";
        return view('shift.timeclock.result',compact('employee','shifts','inout','result','records','forgotten','message'));
    }
    private function clockEmployee($location,$employee,$now,$inout,$comment)
    {
    	$clock = new Clock;
      if($inout){
        $clock->clockIn = $now;
      } else {
        $clock->clockOut = $now;
        In::where('employee_id',$employee)->delete();
      }
    	$clock->location_id = $location;
    	$clock->employee_id = $employee;
    	$clock->comment = $comment;
    	$clock->save();

      if($inout){
        $in = new In;
        $in->clock_id = $clock->id;
        $in->employee_id = $employee;
        $in->save();
      }
      return $clock;

    }
    public function clockOut(){
        $this->validate(request(),[
            'employeeCard' => 'required',
            ]);
        $employee = $this->findEmployee(request('employeeCard'));
        if(!$employee){
            return view('shift.timeclock.notEmployee');
        }
    	  $result = false;
        $inout = false;
        $now = Carbon::now();
    	 
   		
   		 $shifts = Shift::where('employee_id',$employee->id)->whereDate('start',$now->toDateString())->get();
    	 $inShift = In::where('employee_id',$employee->id)->first();
    
      if(is_null($inShift)){ // currently not in shift
          return view('shift.timeclock.noClockIn',compact('employee'));
      } else {
            $latest = Clock::find($inShift->clock_id);
            $latest->clockOut = $now;
            $latest->save();
            $result = true;
            $inShift->delete();
      }

   		  $records = Clock::where('employee_id',$employee->id)->whereDate('clockIn',$now->toDateString())->get();
        return view('shift.timeclock.result',compact('employee','shifts','inout','result','records'));
    }
 
  

    private function findEmployee($id){
    	if(is_numeric($id)){
    		return Employee::find($id);
    	} else {
    		return Employee::where('employeeNumber',$id)->first();
    	}
    }

    public function inShift(){
      $inShiftEmployees = Employee::has('shift')->get();
    
      return view('shift.timeclock.inShiftEmployees',compact('inShiftEmployees'));
    }

}