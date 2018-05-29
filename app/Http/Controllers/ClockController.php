<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use App\Shift;
use App\Clock;
use App\In;
use App\Location;
use App\Datetime;
use Carbon\Carbon;
date_default_timezone_set("America/Toronto");
class ClockController extends Controller
{

    public function index(){
        if(Gate::allows('can-clockin')){
          //return view('shift.timeclock.inout'); 
          $location = Location::find(Auth::user()->authorization->location_id);
          return view('shift.timeclock.index',compact('location'));
        } else {
          return 'Not Authorized';
        }
    }
    public function in(){
        if(Gate::allows('can-clockin')){
          return view('shift.timeclock.clockin'); 
        } else {
          return 'Not Authorized';
        }
    	
    }
    public function out(){
      if(Gate::allows('can-clockin')){
          return view('shift.timeclock.clockout'); 
        } else {
          return 'Not Authorized';
        }
    	
    }
    public function clockIn(Request $r)
    {
      
      $auth = Auth::user()->authorization;
      if($auth->type === 'location'){
        $location = $auth->location->id;
      } else {
        return ['status'=>'danger','messageTitle' => 'Error','message'=>'Not Authorized'];
      }

    	$this->validate(request(),[
    		'employeeCard' => 'required',
    		]);
      $card = strtoupper($r->employeeCard);
    	$employee = $this->findEmployee($card);

    	if(!$employee){
        return ['status'=>'danger','messageTitle' => 'Error','message'=>'无此员工'];
    		// return view('shift.timeclock.notEmployee');
    	}
    	if($employee->status != 'active'){
        return ['status'=>'warning','messageTitle' => '此卡已无效','message'=>"此员工卡($card)已无效。 该员工可能已离职或正在休假。如果不是，请联系店长更改员工状态。"];
    		// return view('shift.timeclock.notActiveEmployee',compact('employee'));
    	}
      
      $inout = $r->inOut; //clock in or out;
      
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
        if($result){
          
          return [
            'status' => 'success',
            'messageTitle' => 'Clock In',
            'message'=> '打卡成功！ 开始上班',
            'shifts' => $shifts,
            'records' => $records,
            'forgotten' => $forgotten,
          ];
        } else {
          return [
            'status' => 'warning',
            'messageTitle' => 'Clock In',
            'message'=> '当前已有上班打卡记录。',
            'shifts' => $shifts,
            'records' => $records,
            'forgotten' => $forgotten,
          ];
        }
        
        // return view('shift.timeclock.result',compact('employee','shifts','inout','result','records','forgotten','message'));

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
    public function clockOut(Request $r){
        $this->validate(request(),[
            'employeeCard' => 'required',
            ]);
        $card = strtoupper($r->employeeCard);
    	  $employee = $this->findEmployee($card);
        
        if(!$employee){
          return ['status'=>'danger','messageTitle' => 'Error','message'=>'无此员工'];
            // return view('shift.timeclock.notEmployee');
        }
    	  $result = false;
        $inout = false;
        $now = Carbon::now();
    	 
   		
   		 $shifts = Shift::where('employee_id',$employee->id)->whereDate('start',$now->toDateString())->get();
    	 $inShift = In::where('employee_id',$employee->id)->first();
    
      if(is_null($inShift)){ // currently not in shift
          // return view('shift.timeclock.noClockIn',compact('employee'));
          return ['status'=>'info','messageTitle' => '无打卡记录','message'=>"无此员工（$card, $employee->name ）的当日打卡记录."];
      } else {
            $latest = Clock::find($inShift->clock_id);
            $latest->clockOut = $now;
            $latest->save();
            $result = true;
            $inShift->delete();
      }

         $records = Clock::where('employee_id',$employee->id)->whereDate('clockIn',$now->toDateString())->get();
         return [
          'status' => 'link',
          'messageTitle' => 'Clock Out',
          'message'=> 'Clocked out！ 结束了当前的工作计时。',
          'shifts' => $shifts,
          'records' => $records,
        ];
        // return view('shift.timeclock.result',compact('employee','shifts','inout','result','records'));
    }
 
  

    private function findEmployee($id){
    	if(is_numeric($id)){
    		return Employee::find($id);
    	} else {
    		return Employee::where('employeeNumber',$id)->first();
    	}
    }

    public function inShift(){
      $subheader = "Who's In";
      $inShiftEmployees = Employee::has('shift')->get();
      $locations = Location::all();
      return view('shift.timeclock.inShiftEmployees',compact('locations','inShiftEmployees','subheader'));
    }
    public function shiftClocks()
    {
      $locations = Location::pluck('name','id');
      $dates = Datetime::periods(Carbon::now()->year);
      $subheader = 'Employee Clocks';
      return view('clock.index',compact('subheader','dates','locations'));
    }
    public function clocksByLocationDate(Request $r)
    {
      $clocks = Clock::where('location_id',$r->location)->whereDate('clockIn',$r->date)->get();
      return View::make('clock.clockTable',compact('clocks'))->render();

    }
    public function show(Request $r)
    {
      return Clock::find($r->clockId);
    }
    public function update(Request $r)
    {
      $clock = Clock::find($r->clockId);

      if(strlen($r->clockIn) == 19){
        $clock->clockIn = $r->clockIn;
      } else {
      $clock->clockIn = $r->clockIn.':00';
      }
      if(strlen($r->clockOut) == 19){
         $clock->clockOut = $r->clockOut;
      } else {
         $clock->clockOut = $r->clockOut.':00';
      }
     
      $clock->comment = $r->comment;
      $clock->save();
      return 'success';
    }
    public function store(Request $r)
    { 
      $clock = new Clock;
      $clock->location_id = $r->location;
      $clock->employee_id = $r->employee;
      $clock->clockIn = $r->clockIn.':00';
      $clock->clockOut = $r->clockOut.':00';
      $clock->comment = $r->comment;
      $clock->save();
      return 'success';
    }
    public function destroy($id)
    {
      Clock::destroy($id);
      return 1;
    }

}
