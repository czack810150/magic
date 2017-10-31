<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_location extends Model
{
    public function job(){
    	return $this->belongsTo('App\Job');
    }
    public function location(){
    	return $this->belongsTo('App\Location');
    }
}
