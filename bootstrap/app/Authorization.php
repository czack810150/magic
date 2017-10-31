<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
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
