<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
   // protected $dates = array('start','end');

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }
}
