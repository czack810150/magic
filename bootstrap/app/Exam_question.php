<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_question extends Model
{
	protected $fillable = ['question_id','answer_id'];
    public function exam()
    {
    	return $this->belongsTo('App\Exam');
    }
    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
    public function answer()
    {
    	return $this->belongsTo('App\Answer');
    }
}
