<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score_item extends Model
{
   protected $fillable = ['score_category_id','name','value','myOrder'];

    public function score_category()
    {
    	return $this->belongsTo('App\Score_category');
    }
}
