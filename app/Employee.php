<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function clock()
    {
    	return $this->hasMany('App\Clock');
    }

    public function location()
    {
    	return $this->belongsToMany('App\Location');
    }

    public function scopeActiveEmployee($query)
    {
    	return $query->where('status','active');
    }

}
