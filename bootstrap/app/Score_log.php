<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score_log extends Model
{
    protected $fillable =['date','location_id','employee_id','score_item_id','value'];
}
