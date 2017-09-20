<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function answer()
    {
    	return $this->belongsTo('App\Question');
    }
}
