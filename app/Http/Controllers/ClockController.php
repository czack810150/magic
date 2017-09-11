<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Employee;
use App\Shift;
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
    	$alreadyClocked = false;
    	$inout = true; //clock in or out;
    	$clock = date('Y-m-d H:i:s');
    	$date = date('Y-m-d');
   		$shifts = Shift::where('employee_id',$employee->id)->whereDate('scheduleIn',date('Y-m-d'))->get();
   		
        if(count($shifts) == 1){ // check if there is only one shift scheduled for the day
        	if(!$shifts[0]->clockIn){ // check if already clocked in
        		$shifts[0]->clockIn = $clock;
        		$shifts[0]->save();
        	} else { // already clocked in
        		$alreadyClocked = true;
        	}

        	
        } else if(count($shifts) > 1){ // check if there are multiple shifts scheduled for the day
        	foreach($shifts as $s){
        		if($s->scheduleOut > $clock ){
        			if(!$s->clockIn){ // check if already clocked in
        				$s->clockIn = $clock; // current time less than scheduled out, clock this shift
        				$s->save();
        				break;
        			} else {
        				$alreadyClocked = true;
        				break;
        			}
        			
        		}
        	}


        } else { // no scheduled shift for the day
        	$clockedShifts = Shift::where('employee_id',$employee->id)->whereDate('clockIn',date('Y-m-d'))->orderBy('clockIn','asc')->get();
        	
        	if(!count($clockedShifts)){ // no clocked in record
        			$shift = new Shift;
        			$shift->clockIn = $clock;
        			$shift->employee_id = $employee->id;
        			$shift->created_by = $employee->id;
        			$shift->comment = 'No scheduled shift today, the employee clocked in anyway.';
        			$shift->location_id= $location;
        			$shift->save();
        			$shifts[] =  $shift; // pass data to view
        	} else { //already clocked in an unscheduled shift
        		$newShift = true;
        		foreach($clockedShifts as $c){
        			$shifts[] = $c; // add data to view
        			if(!$c->clockOut){ // if clocked out, add a new record
        				$alreadyClocked = true;
        				$newShift = false;
        				break;
        			}
        		}
        		if($newShift){
        					$shift = new Shift;
        					$shift->clockIn = $clock;
        					$shift->employee_id = $employee->id;
        					$shift->created_by = $employee->id;
        					$shift->comment = 'No scheduled shift today, the employee clocked in anyway.';
        					$shift->location_id= $location;
        					$shift->save();
        					$shifts[] =  $shift; // pass data to view
        					$newShift = false;
        				}
        	}
        
        }
        
    	return view('shift.timeclock.result',compact('employee','inout','shifts','alreadyClocked'));
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
    	$alreadyClocked = false;
        $inout = false;
        $clock = date('Y-m-d H:i:s');
    	$date = date('Y-m-d');
   		$shifts = Shift::where('employee_id',$employee->id)->whereDate('scheduleIn',date('Y-m-d'))->get();

   		if(count($shifts) == 1){ // check if there is only one shift scheduled for the day
        	if(!$shifts[0]->clockOut){ // check if already clocked in
        		$shifts[0]->clockOut = $clock;
        		$shifts[0]->save();
        	} else { // already clocked in
        		$alreadyClocked = true;
        	}	
        } else if(count($shifts) > 1){ // check if there are multiple shifts scheduled for the day

        	$size = count($shifts);
        	for($i = 0; $i < $size - 1; $i++){
     			if($shifts[$i]->scheduleIn < $clock && $clock <= $shifts[$i]->scheduleOut){
     				if(!$shifts[$i]->clockOut){ // check if already clocked out
        				$shifts[$i]->clockOut = $clock; // current time less than scheduled out, clock this shift
        				$shifts[$i]->save();
        				break;
        			} else {
        				$alreadyClocked = true;
        				break;
        			}
     			} else if($shifts[$i]->scheduleOut < $clock && $clock <= $shifts[$i+1]->scheduleIn){
     				if(!$shifts[$i]->clockOut){ // check if already clocked out
        				$shifts[$i]->clockOut = $clock; // current time less than scheduled out, clock this shift
        				$shifts[$i]->save();
        				break;
        			} else {
        				$alreadyClocked = true;
        				break;
        			}
     			} else if( $clock > $shifts[$i+1]->scheduleIn && $clock <= $shifts[$i+1]->scheduleOut) { 
						$shifts[$i+1]->clockOut = $clock; // current time less than scheduled out, clock this shift
        				$shifts[$i+1]->save();
        				break;
     			} else if( $clock <= $shifts[0]){
     					dd('you can not clock out before first shift starts');
     					break;
     			}
        	} 


        } else { // no scheduled shifts
        	$clockedShifts = Shift::where('employee_id',$employee->id)->whereDate('clockIn',date('Y-m-d'))->orderBy('clockIn','asc')->get();
        	
        	if(!count($clockedShifts)){ // no clocked in record
        			dd('you don\'t have any clock in. 无当日上班记录');
        	} else { //already clocked in an unscheduled shift
        		
        		foreach($clockedShifts as $c){
        			$shifts[] = $c; // add data to view
        			if($c->clockOut){ // if clocked out, add a new record
        				$alreadyClocked = true;
        				break;
        			} else {
        				$c->clockOut = $clock;
        				$c->save();
        				break;
        			}
        		}
        }
    	}

        return view('shift.timeclock.result',compact('employee','shifts','inout','alreadyClocked'));
    }
    private function findEmployee($id){
    	if(is_numeric($id)){
    		return Employee::find($id);
    	} else {
    		return Employee::where('employeeNumber',$id)->first();
    	}
    }

}
