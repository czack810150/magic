<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Shift extends Model
{
   protected $dates = array('start','end');
   protected $guarded = [];

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
    public function duty()
    {
      return $this->BelongsTo('App\Duty');
    }

    public function scheduledHours(){
        return DB::table('shifts')->select(DB::raw('UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start)'))
                    ->get();
    }


    public static function scheduledShifts($employee,$location,$start,$end){
        $shifts = Shift::where('employee_id',$employee)->where('location_id',$location)->where('start','>=',$start)->whereDate('end','<=',$end)->
                            orderBy('start')->get();
        return $shifts;
    }

    public static function fetchDay($location,$date)
    {
       $shifts = Shift::where('location_id',$location)->whereDate('start',$date)->get();
       foreach($shifts as $s)
       {
        $s->title = $s->role->c_name;
        $s->employee;
       }
       return $shifts;
    }
    public static function fetchPeriod($location,$start,$end)
    {
       $shifts = Shift::where('location_id',$location)->where('start','>=',$start)->where('start','<',$end)->get();
       foreach($shifts as $s)
       {
            $s->resourceId = $s->employee_id;
            $s->employee;
            $s->employee->job;
            $s->role;
            $s->duty;
       }
       return $shifts;
    }
    public static function weekTotalHour($employee,$location,$start,$end){
      $weekTotal = DB::table('shifts')->select(DB::raw('SUM(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 AS total'))->where('employee_id',$employee)->where('location_id',$location)->whereBetween('start',[$start,$end])->first();

      if($weekTotal){
        return round($weekTotal->total,2);
      } else {
        return 0;
      }
      
    }

    public static function locationStats($location,$startStr,$endStr){
      $start = Carbon::createFromFormat('Y-m-d',$startStr);
      $end = Carbon::createFromFormat('Y-m-d',$endStr);
      $diff = $start->diffInDays($end);
      $result = collect();
      
      for($i = 0; $i < $diff; $i++){
        $result->push(['date' => $start->toDateString(),'totalHour' => self::dailyTotal($location,$start->toDateString())]);
        $start->addDay();
      
      }
      return $result;
    }

    public static function dailyTotal($location,$date)
    {
      $weekTotal = DB::table('shifts')->select(DB::raw('SUM(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 AS totalHour'))->where('location_id',$location)->whereDate('start',$date)->first()->totalHour;
      if($weekTotal){
        return $weekTotal;
      } else {
        return 0;
      }
    }
   
}
