<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function answer()
    {
    	return $this->hasMany('App\Answer');
    }
    public function question_category()
    {
    	return $this->belongsTo('App\Question_category');
    }
}
