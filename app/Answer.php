<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $fillable = ['answer','correct','question_id'];
	protected $touches = ['question'];

    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
    public function scopeCorrect($query)
    {
    	return $query->where('correct',1);
    }
}
