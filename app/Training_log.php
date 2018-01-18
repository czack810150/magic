<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training_log extends Model
{
    protected $fillable = ['employee_id','trainer_id','item_id','date_trained'];

    public function item()
    {
    	return $this->belongsTo('App\Training_item');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function trainer()
    {
    	return $this->belongsTo('App\Employee');
    }
}
