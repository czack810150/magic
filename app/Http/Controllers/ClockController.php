<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Employee;
use App\Shift;
use App\Clock;
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
    	$location = 9;
    	$inout = true; //clock in or out;
    	$time = date('Y-m-d H:i:s');
    	$date = date('Y-m-d');
    	$inShift = false;
   		$shifts = Shift::where('employee_id',$employee->id)->whereDate('start',date('Y-m-d'))->get();	
   		$result = false;

   		$latest = Clock::where('employee_id',$employee->id)->whereDate('in',$date)->orderBy('in','desc')->first();
   		if(count($latest)){
   		
   			if($latest->out){
        	$this->clockEmployee($location,$employee->id,$time,$inout,'');
   				$result = true;
   			} else {
   				$result = false;
   			}

   		} else { // no record today, clock in
   			$this->clockEmployee($location,$employee->id,$time,$inout,'');
   			$result = true;
   		}
   	
    	  $records = Clock::where('employee_id',$employee->id)->whereDate('in',$date)->get();
        $forgotten  = Clock::where('employee_id',$employee->id)->whereDate('in','!=',$date)->where('out',null)->orderby('in','desc')->first();
        $message = "You can do it!";
        return view('shift.timeclock.result',compact('employee','shifts','inout','result','records','forgotten','message'));
    }
    private function clockEmployee($location,$employee,$time,$inout,$comment)
    {
    	$clock = new Clock;
      if($inout){
        $clock->in = $time;
      } else {
        $clock->out = $time;
      }
    	$clock->location_id = $location;
    	$clock->employee_id = $employee;
    	$clock->comment = $comment;
    	$clock->save();

    }
    public function clockOut(){
        $this->validate(request(),[
            'employeeCard' => 'required',
            ]);
        $employee = $this->findEmployee(request('employeeCard'));
        if(!$employee){
            return view('shift.timeclock.notEmployee');
        }
        $location = 9;
    	  $result = false;
        $inout = false;
        $time = date('Y-m-d H:i:s');
    	  $date = date('Y-m-d');
   		
   		$shifts = Shift::where('employee_id',$employee->id)->whereDate('start',date('Y-m-d'))->get();
    	$latest = Clock::where('employee_id',$employee->id)->whereDate('in',$date)->orderBy('in','desc')->first();
  
    	if(count($latest)){
    		if($latest->out){
    			$result = false;
    		} else {
    			
          $latest->out = $time;
          $latest->save();
          $result = true;
    		}

    	} else { // no record
    		 return view('shift.timeclock.noClockIn');
    	}
   		  $records = Clock::where('employee_id',$employee->id)->whereDate('in',$date)->get();
        return view('shift.timeclock.result',compact('employee','shifts','inout','result','records'));
    }
 
  

    private function findEmployee($id){
    	if(is_numeric($id)){
    		return Employee::find($id);
    	} else {
    		return Employee::where('employeeNumber',$id)->first();
    	}
    }

}
