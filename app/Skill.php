<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function skill_category()
    {
    	return $this->belongsTo('App\Skill_category');
    }
}
