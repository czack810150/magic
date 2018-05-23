<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTraining extends Model
{
    protected $fillable = ['employee_id','name','score','start','end'];
}
