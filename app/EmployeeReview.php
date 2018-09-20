<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeReview extends Model
{
    protected $fillable = ['employee_id','manager_id','reviewed','pass','next','manager_score','self_score','performace','hr_score','org_score','result','manager_note','self_note'];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function manager()
    {
    	return $this->belongsTo(Employee::class,'manager_id');
    }
}
