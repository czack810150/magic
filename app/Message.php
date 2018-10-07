<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['employee_id','subject','body'];

    public function message_to()
    {
    	return $this->hasMany('App\Message_to');
    }
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
}
