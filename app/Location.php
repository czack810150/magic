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
    public function scopeNonOffice($query)
    {
        return $query->where('type','!=','office');
    }
    public function employee_location(){
    	return $this->hasMany('App\Employee_location');
    }

    public function tips()
    {
        return $this->hasMany('App\Payroll_tip');
    }
    public function manager()
    {
        return $this->belongsTo('App\Employee');
    }
    public function leave()
    {
        return $this->hasMany('App\Leave');
    }
    public function sales()
    {
        return $this->hasMany('App\Sale');
    }


}
