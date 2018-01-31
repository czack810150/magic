<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function employee()
    {
    	return $this->hasMany('App\Employee');
    }
    public static function typeCount($type,$location)
    {
    	$count = 0;
    	$jobs = self::where('type',$type)->where('valid',true)->get();
    	foreach($jobs as $job){
    		if(is_null($location)){
    			$count += $job->employee->where('status','active')->count();
    		} else {
    			$count += $job->employee->where('status','active')->where('location_id',$location)->count();
    		}
    	}
    	return $count;
    }
}
