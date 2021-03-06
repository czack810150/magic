<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;
use App\Location;
use App\Datetime;
use App\Employee;
use Carbon\Carbon;
use App\Duty;

class ShiftController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::get();
        return view('shift.shift.index',compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {
        $shift = Shift::create([
            'location_id' => $r->location,
            'employee_id' => $r->employee,
            'role_id' => $r->role,
            'duty_id' => $r->duty,
            'start' => $r->start,
            'end' => $r->end,
            'published' => 0,
            'special' => $r->special == 'true'?true:false,
            'comment' => $r->note
        ]);
        $shift->periodTotal  = Shift::weekTotalHour($r->employee,$r->location,$r->periodStart,$r->periodEnd);
        $shift->duration = $shift->start->diffInSeconds($shift->end)/3600;
        return $shift;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);
        $shift->employee_id = $request->employee;
        $shift->role_id = $request->role;
        $shift->duty_id = $request->duty;
        $shift->special = $request->special == 'true'?true:false;
        $shift->start = $request->start.":00";
        $shift->end = $request->end.":00";
        $shift->comment = $request->note;
        $shift->save();
        $shift->employee;
        $shift->employee->job;
        $shift->duty;
        $shift->role;
        $shift->periodTotal = Shift::weekTotalHour($request->employee,$shift->location_id,$request->periodStart,$request->periodEnd);
        $shift->duration = $shift->start->diffInSeconds($shift->end)/3600;
        return $shift;
    }

    public function destroy(Request $r,$id)
    {
        $shift = Shift::find($id);
        $removedShift = $shift;
        if($shift->delete()){
            $removedShift->periodTotal = Shift::weekTotalHour($removedShift->employee_id,$removedShift->location_id,$r->periodStart,$r->periodEnd);
            $removedShift->duration = $shift->start->diffInSeconds($shift->end)/3600;
            return $removedShift;
        } else {
            return false;
        }
    }
    public function getOldTotal(Request $r){
        $shift = Shift::find($r->shift);
        $shift->periodTotal = Shift::weekTotalHour($shift->employee_id,$r->location,$r->periodStart,$r->periodEnd);
        $shift->total = $shift->start->diffInSeconds($shift->end)/3600;
        return $shift;
    }

    public function apiCreate(Request $request)
    {
       
        $shift = new Shift;
        $shift->location_id = $request->location;  
        $shift->employee_id = $request->employee_id;
        $shift->role_id = $request->role;
         $shift->start = $request->start_time;
        $shift->end = $request->end_time;        
        // //$shift->start = '2017-09-27 11:00:00';
        // $shift->end = '2017-09-25 12:25:00';     
        $shift->published = 1;
        $shift->comment = $request->note;
     
        $shift->created_by = 1;
        $shift->save();      
        return $shift->start;
    }
    public function getShift(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $location = $request->input('location');
        $shifts = Shift::where('location_id',$location)
                    ->whereDate('start','>=',$start)
                    ->whereDate('end','<',$end)
                    ->get();
        return view('shift/shift/shiftList',compact('shifts'));
    }
    public function fetchWeek(Request $r)
    {
        return Shift::fetchPeriod($r->location,$r->start,$r->end);
    }
    public function parseShiftTime(Request $r)
    {
        return Datetime::shiftParser($r->str);
    }
    public function getResourcesByLocation(Request $r)
     {
        $employees =  Employee::where('location_id',$r->location)->ActiveAndVacationEmployees()->get();
        $borrowed = collect();
        $shifts = Shift::where('location_id',$r->location)->whereBetween('start',[$r->start,$r->end])->get();
        foreach($shifts as $s){
            if($s->employee->location_id != $r->location){
                $borrowed->push($s->employee);
            }
        }
        if(count($borrowed)){ 
            $borrowed = $borrowed->unique();
            $employees = $employees->merge($borrowed);
        }

        foreach($employees as $e){
            $e->job;
            $e->job_type = $e->job->type;
            $e->weekTotal = Shift::weekTotalHour($e->id,$r->location,$r->start,$r->end);
            $start  = Shift::where('employee_id',$e->id)->where('location_id',$r->location)->whereDate('start',$r->start)->first();
            if($start){
                 $e->firstStart = $start['start']->format('U');
            }
            else {
                $e->firstStart = 7226582400;
            }
        }
        return $employees;
     }

     public function copyShifts(Request $r){
       $msg = '';
       $from = Carbon::createFromFormat('Y-m-d',$r->from);
       $to = Carbon::createFromFormat('Y-m-d',$r->to);
       $dFrom = Carbon::createFromFormat('Y-m-d',$r->dFrom);
       $dTo = Carbon::createFromFormat('Y-m-d',$r->dTo);

       if($r->clear){ // delete all shifts for current period
        $currentPeriodShifts = Shift::where('location_id',$r->location)->whereBetween('start',[$dFrom->toDateString(),$dTo->toDateString()])->delete();
        }
      
       $diff =  $dFrom->diffInDays($from);
       $shifts = Shift::where('location_id',$r->location)->whereBetween('start',[$from->toDateString(),$to->toDateString()])->get();
       
       if($dFrom->greaterThanOrEqualTo($from)){
        foreach($shifts as $s){
            $shiftStartDate = Carbon::createFromFormat('Y-m-d H:i:s',$s->start)->addDays($diff);
            if(Employee::onboardCheck($s->employee_id,$shiftStartDate->toDateString()))
            {
                Shift::create([
                'location_id' => $r->location,
                'employee_id' => $s->employee_id,
                'role_id' => $s->role_id,
                'duty_id' => $s->duty_id,
                'special' => $s->special,
                'start' => $shiftStartDate->toDateTimeString(),
                'end' => Carbon::createFromFormat('Y-m-d H:i:s',$s->end)->addDays($diff)->toDateTimeString(),
                'published'=> false,
            ]);
            }
            
        }
        $msg = 'copied from past';
       } else {
        foreach($shifts as $s){
            Shift::create([
                'location_id' => $r->location,
                'employee_id' => $s->employee_id,
                'role_id' => $s->role_id,
                'duty_id' => $s->duty_id,
                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$s->start)->subDays($diff)->toDateTimeString(),
                'end' => Carbon::createFromFormat('Y-m-d H:i:s',$s->end)->subDays($diff)->toDateTimeString(),
                'published'=> false,
            ]);
        }
        $msg = 'copied from future';
       } 
        return $msg;
     }
     public function countShifts(Request $r){
        $shifts = Shift::where('location_id',$r->location)->whereBetween('start',[$r->from,$r->to])->count();
        return $shifts;
     }
     public function fetchStats(Request $r)
     {
        $stats = Shift::locationStats($r->location,$r->from,$r->to);
        $duties = Duty::get();
        return view('magicshift.stats',compact('stats','duties'));
     }
}
