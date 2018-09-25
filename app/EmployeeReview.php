<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeReview extends Model
{
    protected $fillable = ['employee_id','manager_id','reviewed','exam_id','pass','reviewDate','nextReview','manager_score','self_score','performance','hr_score','org_score','result','description','manager_note','self_note'];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function manager()
    {
    	return $this->belongsTo(Employee::class,'manager_id');
    }
    public function exam()
    {
    	return $this->belongsTo(Exam::class);
    }
}
