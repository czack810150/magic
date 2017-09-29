<?php

namespace App;

use Illuminate\Support\Facades\DB;
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
    public function scheduledHours(){
        return DB::table('shifts')->select(DB::raw('UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start)'))
                    ->get();
    }
}
