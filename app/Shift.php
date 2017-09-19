<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
   protected $dates = array('start','end');

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
}
