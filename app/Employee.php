<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function clock()
    {
    	return $this->hasMany('App\Clock');
    }

    public function location()
    {
    	return $this->belongsToMany('App\Location');
    }

     public function shift()
    {
        return $this->hasOne('App\In');
    }

    public function scopeActiveEmployee($query)
    {
    	return $query->where('status','active');
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


}
