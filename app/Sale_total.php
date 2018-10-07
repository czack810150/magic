<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale_total extends Model
{
    protected $fillable = ['location_id','date','total'];
}
