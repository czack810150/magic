<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    protected $dates = array('in','out');

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
}
