<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreRecord extends Model
{
    protected $fillable =['name','myOrder'];
   public function items()
   {
   	return $this->hasMany('App\ScoreItem');
   }
}
