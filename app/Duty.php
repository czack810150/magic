<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    public function shifts(){
    	return $this->hasMany('App\Shift');
    }
}
