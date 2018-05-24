<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTrainingQuestion extends Model
{
    protected $fillable = ['exam_training_id','question_id'];
    public function question(){
        return $this->belongsTo('App\Question');
    }
}
