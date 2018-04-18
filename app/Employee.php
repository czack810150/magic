<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Location;
use DB;
class Employee extends Model
{
    protected $fillable = ['newbie','employeeNumber','email','firstName','lastName','cName','location_id','hired','termination','status','job_id'];
    public function user()
    {
        return $this->hasOne('App\Authorization');
    }
    public function employee_profile()
    {
        return $this->hasOne('App\Employee_profile');
    }
    public function employee_background()
    {
        return $this->hasOne('App\Employee_background');
    }
    public function employee_trace()
    {
        return $this->hasOne('App\Employee_trace');
    }

    public function getHiredAttribute($value)
    {
        if(!is_null($value))
            return Carbon::createFromFormat('Y-m-d',$value);
        else
            return null;    
    }
    public function getTerminationAttribute($value)
    {
        if(!is_null($value))
            return Carbon::createFromFormat('Y-m-d',$value);
        else
            return null;
    }
    public function clock()
    {
    	return $this->hasMany('App\Clock');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    	//return $this->belongsToMany('App\Location');
    }

     public function shift()
    {
        return $this->hasOne('App\In');
    }
   
    public function exam()
    {
        return $this->hasMany('App\Exam');
    }

    public function training()
    {
        return $this->hasMany('App\Training_log');
    }

    public function schedule(){
        return $this->hasMany('App\Shift');
    }

    public function job_location()
    {
        return $this->hasMany('App\Employee_location');
    }
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
    public function authorization()
    {
        return $this->hasOne('App\Authorization');
    }

    public static function jobBreakdown($location)
    {
        if(is_null($location)){
            return DB::table('employees')->join('jobs','jobs.id','=','employees.job_id')->select(DB::raw('count(*) as count,jobs.rank,jobs.type'))->where('employees.status','active')->groupBy('jobs.id')->orderBy('jobs.id')->get();
        } else {
            return DB::table('employees')->join('jobs','jobs.id','=','employees.job_id')->select(DB::raw('count(*) as count,jobs.rank,jobs.type'))->where('employees.status','active')->where('location_id',$location)->groupBy('jobs.id')->orderBy('jobs.id')->get();
        }
        
    }
    public static function locationEmployeesCount(){
        $locations = Location::get();
        $result = array();
        foreach($locations as $l){
            $result[$l->name]['totalHeadCount'] = $l->employee->count();
            $result[$l->name]['totalActive'] = $l->employee->where('status','active')->count();
            $result[$l->name]['activeRate'] = $result[$l->name]['totalActive']/$result[$l->name]['totalHeadCount'];
        }
        return $result;
    }
    public static function typesCount(){
        $locations = Location::get();
        $result = array();
        // foreach($locations as $l){
        //     $result[$l->name]['totalHeadCount'] = $l->employee->count();
        //     $result[$l->name]['totalActive'] = $l->employee->where('status','active')->count();
        //     $result[$l->name]['activeRate'] = $result[$l->name]['totalActive']/$result[$l->name]['totalHeadCount'];
        // }
        return $result;
    }
    // scopes
    public function scopeActiveEmployee($query)
    {
        return $query->where('status','active');
    }
    public function scopeTerminatedEmployees($query)
    {
        return $query->where('termination','!=',null);
    }
    public function scopeActiveAndVacationEmployees($query)
    {
        return $query->where('status','active')->orWhere('status','vacation');
    }

    public function message()
    {
        return $this->hasMany('App\Message_to');
    }

    public function availability()
    {
        return $this->hasOne('App\Availability');
    }
    public function leave()
    {
        return $this->hasMany('App\Leave');
    }
    public function approvedLeave()
    {
        return $this->hasMany('App\Leave');
    }
    public function promotion()
    {
        return $this->hasMany('App\JobPromotion');
    }
    


}
