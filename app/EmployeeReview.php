<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeReview extends Model
{
    protected $casts = [
        'self_data' => 'array'
    ];
    protected $guarded = [];
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
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
