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
        return ['status'=>'danger','messageTitle' => 'Error','message'=>'无此员工','shifts'=>[],'records' => []];
    		// return view('shift.timeclock.notEmployee');
    	}
    	if($employee->status != 'active'){
        return ['status'=>'warning','messageTitle' => '此卡已无效','message'=>"此员工卡($card)已无效。 该员工可能已离职或正在休假。如果不是，请联系店长更改员工状态。",'shifts'=>[],'records' => []];
    		// return view('shift.timeclock.notActiveEmployee',compact('employee'));
    	}
      
      $inout = $r->inOut; //clock in or out;
      
    	$now = Carbon::now();
    	
      $shifts = Shift::where('employee_id',$employee->id)->whereDate('start',$now->toDateString())->get();
      if(count($shifts)){
        foreach($shifts as $s){
          $s->role;
          $s->duty;
          
        }
      }	
   		$result = false;

      $inShift = In::where('employee_id',$employee->id)->first();
   	
   		if(is_null($inShift)){ // no record today, clock in
   	    	$clockIn = $this->clockEmployee($location,$employee->id,$now,$inout,''); // new clock record
          $result = true;
   		} 
   	
    	  $records = Clock::where('employee_id',$employee->id)->whereDate('clockIn',$now->toDateString())->get();
        $forgotten  = Clock::where('employee_id',$employee->id)->whereDate('clockIn','<',$now->toDateString())->where('clockOut',null)->orderby('clockIn','desc')->first();

        if($result){
          $now = Carbon::now();
          $days = $now->diffInDays($employee->hired);
          $message = "<strong>$employee->name </strong> 开始了在大槐树第 $days 天的工作。";
          
          return [
            'status' => 'success',
            'messageTitle' => 'Clock In',
            'message'=> $message,
            'shifts' => $shifts,
            'records' => $records,
            'forgotten' => $forgotten,
            'greeting' => '你好，你是我们团队里的重要一员，让我们一起开始今天的工作吧！'
          ];
        } else {
          return [
            'status' => 'warning',
            'messageTitle' => 'Clock In',
            'message'=> '当前已有上班打卡记录。',
            'shifts' => $shifts,
            'records' => $records,
            'forgotten' => $forgotten,
            'greeting' => '你好，你是我们团队里的重要一员，让我们一起开始今天的工作吧！'
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
          return ['status'=>'danger','messageTitle' => 'Error','message'=>'无此员工','shifts'=>[],'records' => []];
            // return view('shift.timeclock.notEmployee');
        }
    	  $result = false;
        $inout = false;
        $now = Carbon::now();
    	 
   		
        $shifts = Shift::where('employee_id',$employee->id)->whereDate('start',$now->toDateString())->get();
        if(count($shifts)){
          foreach($shifts as $s){
            $s->role;
            $s->duty;
          }
        }
    	 $inShift = In::where('employee_id',$employee->id)->first();
       $records = Clock::where('employee_id',$employee->id)->whereDate('clockIn',$now->toDateString())->get();
      if(is_null($inShift)){ // currently not in shift
          // return view('shift.timeclock.noClockIn',compact('employee'));
          return ['status'=>'info','messageTitle' => '无打卡记录','message'=>"无此员工（$card, $employee->name ）的当日打卡记录.",'records' => $records,'shifts'=>[]];
      } else {
            $latest = Clock::find($inShift->clock_id);
            if($latest){
              $latest->clockOut = $now;
              $latest->save();
              $result = true;
              $inShift->delete();
            } else {
              $inShift->delete();
              return ['status'=>'dark','messageTitle' => '打卡记录已丢失','message'=>"请于店内填写打卡记录登记表，并通知店长。",'records' => $records,'shifts'=>[]];
            }
            
      }

  
         return [
          'status' => 'link',
          'messageTitle' => 'Clock Out',
          'message'=> "Clocked out！ 员工 <strong>$employee->name </strong>结束了当前的工作计时。",
          'shifts' => $shifts,
          'records' => $records,
          'greeting' => '辛苦了！'
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
      $subheader = 'Edit Employee Clocks';
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
    public function viewClocks()
    {
      $subheader = 'View Employee Clocks';
      $locations = Location::pluck('name','id');
      $dates = Datetime::periods(Carbon::now()->year);
      $defaultLocation = Auth::user()->authorization->location_id;
      $employees = Employee::ActiveEmployee()->where('location_id',$defaultLocation)->get();
      
      return view('clock.view',compact('subheader','dates','locations','defaultLocation','employees'));
    }
    public function employeeClocksByDateRange(Request $r){
      $endDate = Carbon::createFromFormat('Y-m-d',$r->endDate)->addDay()->toDateString();

      if($r->employee != 'all'){
        $clocks = Clock::where('employee_id',$r->employee)->whereBetween('clockIn',[$r->startDate,$endDate])->get();
         foreach($clocks as $c){
           $c->location;
           }
          
      } else {
        $clocks = Clock::where('location_id',$r->location)->whereBetween('clockIn',[$r->startDate,$endDate])->get();
         foreach($clocks as $c){
           $c->location;
           $c->employee;
           }
          
      }
      return $clocks;
      
    }

}
