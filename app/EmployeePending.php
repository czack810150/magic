<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePending extends Model
{
    protected $fillable = ['employee_id','status','start','end'];

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
}
