<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_template_question extends Model
{
    protected $fillable = ['question_id','exam_tempalte_id'];
    public function template()
    {
    	return $this->belongsTo('App\Exam_template');
    }
    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
}
