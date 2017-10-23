<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function question()
    {
    	return $this->hasMany('App\Exam_question');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function scopeFinished($query)
    {
    	return $query->where('finished',true);
    }
}
