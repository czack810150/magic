<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\Location;
use App\Employee;

class JobPromotion extends Model
{
    protected $guarded = [];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function getOldJobAttribute($value)
    {
    	return Job::find($value);
    }
    public function getNewJobAttribute($value)
    {
    	return Job::find($value);
    }
    public function getNewLocationAttribute($value)
    {
    	return Location::find($value);
    }
    public function getOldLocationAttribute($value)
    {
    	return Location::find($value);
    }
    public function getModifiedByAttribute($value)
    {
        if($value){
             return Employee::find($value);
         } else {
            return null;
         }
        
    }

}
