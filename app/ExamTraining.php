<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTraining extends Model
{
    protected $fillable = ['employee_id','name','score','start','end'];
    public function employee(){
        return $this->belongsTo('App\Employee');
    }
    public function question(){
        return $this->hasMany('App\ExamTrainingQuestion');
    }
}
