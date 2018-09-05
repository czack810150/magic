<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRate extends Model
{
    protected $fillable = ['employee_id','type','cheque','rate','change','start','end'];
    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }
}
