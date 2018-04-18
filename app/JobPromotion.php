<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\Location;

class JobPromotion extends Model
{
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function getOldJobAttribute($value)
    {
    	return Job::find($value)->rank;
    }
    public function getNewJobAttribute($value)
    {
    	return Job::find($value)->rank;
    }
    public function getNewLocationAttribute($value)
    {
    	return Location::find($value)->name;
    }
    public function getOldLocationAttribute($value)
    {
    	return Location::find($value)->name;
    }

}
