<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class Leave extends Model
{

	protected $dates = [
		'created_at',
		'updated_at',
		'from',
		'to',
	];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function approved()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function type()
    {
    	return $this->belongsTo('App\LeaveType');
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
    public function getApprovedByAttribute($value)
    {
    
        return Employee::find($value);
    }
}
