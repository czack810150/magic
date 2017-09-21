<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $fillable = ['body','question_category_id','difficulty','created_by','mc'];


    public function answer()
    {
    	return $this->hasMany('App\Answer');
    }
    public function question_category()
    {
    	return $this->belongsTo('App\Question_category');
    }
}
