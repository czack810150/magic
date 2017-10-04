<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function employee()
    {
    	return $this->hasMany('App\Employee');
    }

    public function scopeStore($query)
    {
    	return $query->where('type','store');
    }
    public function employee_location(){
    	return $this->hasMany('App\Employee_location');
    }
}
