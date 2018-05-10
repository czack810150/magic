<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name','employee_id','team_id','description'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function teamMember()
    {
        return $this->hasMany('App\TeamMember');
    }
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
