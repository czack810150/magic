<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score_category extends Model
{
   protected $fillable =['name','myOrder'];
   public function items()
   {
   	return $this->hasMany('App\Score_item');
   }
  
}
