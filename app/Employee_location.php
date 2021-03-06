<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee_location extends Model
{
	protected $fillable = ['employee_id','location_id','job_id','start','end','review','notifield'];

    public function job(){
    	return $this->belongsTo('App\Job');
    }
    public function location(){
    	return $this->belongsTo('App\Location');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function getReviewAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d',$value);
    }
}
