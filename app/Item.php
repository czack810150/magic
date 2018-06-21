<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function scopeMenuItems($query){
    	return $query->where('menu',true);
    }
}
