<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_location extends Model
{
	protected $fillable = ['employee_id','location_id','job_id','start','end'];

    public function job(){
    	return $this->belongsTo('App\Job');
    }
    public function location(){
    	return $this->belongsTo('App\Location');
    }
}
