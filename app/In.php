<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class In extends Model
{
    protected $fillable = ['employee_id','clock_id'];

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function clock()
    {
    	return $this->belongsTo('App\Clock');
    }
    
}
