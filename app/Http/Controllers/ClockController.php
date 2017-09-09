<?php

namespace App\Http\Controllers;

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

        $shifts = Shift::where('employee_id',$employee->id)->whereDate('scheduleIn',date('Y-m-d'))->get();
        
       
        $shifts[0]->clockIn = date('Y-m-d H:i:s');
        $shifts[0]->save();

        $inout = true;
    	return view('shift.timeclock.result',compact('employee','inout','shifts'));
    }
    public function clockOut(){
        $this->validate(request(),[
            'employeeCard' => 'required',
            ]);
        $employee = $this->findEmployee(request('employeeCard'));
        if(!$employee){
            return view('shift.timeclock.notEmployee');
        }
        $inout = false;
        return view('shift.timeclock.result',compact('employee','inout'));
    }
    private function findEmployee($id){
    	if(is_numeric($id)){
    		return Employee::find($id);
    	} else {
    		return Employee::where('employeeNumber',$id)->first();
    	}
    }

}
