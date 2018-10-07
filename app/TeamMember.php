<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['team_id','employee_id','id'];
    public function team(){
        return $this->belongsTo('App\Team');
    }
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
