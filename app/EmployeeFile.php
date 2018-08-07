<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    protected $fillable = ['employee_id','type','path','name'];
    public function employee(){
    	return $this->belongsTo('App\Employee');
    }
}
