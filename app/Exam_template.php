<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_template extends Model
{
    public function question()
    {
    	return $this->hasMany('App\Exam_template_question');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }

}
