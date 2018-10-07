<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill_category extends Model
{
    public function skills()
    {
    	return $this->hasMany('App\Skill');
    }
}
