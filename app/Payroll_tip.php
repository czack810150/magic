<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll_tip extends Model
{
    public function getHourlyTipAttribute($value)
    {
    	return $value / 100;
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
}
