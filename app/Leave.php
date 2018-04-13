<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function type()
    {
    	return $this->belongsTo('App\LeaveType');
    }
}
