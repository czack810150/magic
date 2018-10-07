<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message_to extends Model
{
    protected $fillable = ['employee_id','message_id'];
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function message()
    {
    	return $this->belongsTo('App\Message');
    }
    public function scopeUnreadMessages($query)
    {
    	return $query->where('read',false);
    }

}
