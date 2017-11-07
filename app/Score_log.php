<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score_log extends Model
{
    protected $fillable =['date','location_id','employee_id','score_item_id','value'];

    public function score_item()
    {
    	return $this->belongsTo('App\Score_item');
    }
     public function location()
    {
    	return $this->belongsTo('App\Location');
    }
}
