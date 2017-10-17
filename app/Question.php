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
    
    public function exam()
    {
    	return $this->belongsToMany('App\Exam');
    }
    
    public function scopeMc($query)
    {
        return $query->where('mc',true);
    }
    public function scopeSa($query)
    {
        return $query->where('mc',false);
    }  
}
