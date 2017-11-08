<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Employee extends Model
{

    public function employee_profile()
    {
        return $this->hasOne('App\employee_profile');
    }
    public function employee_background()
    {
        return $this->hasOne('App\employee_background');
    }

    public function getHiredAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d',$value);
        
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
    // scopes
    public function scopeActiveEmployee($query)
    {
        return $query->where('status','active');
    }

    


}
