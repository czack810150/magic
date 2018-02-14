<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
   protected $dates = array('start','end');

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
        $s->role;
        $s->employee;
       }
       return $shifts;
    }
}
