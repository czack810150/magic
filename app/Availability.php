<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Availability extends Model
{
    protected $guarded=[];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
}
